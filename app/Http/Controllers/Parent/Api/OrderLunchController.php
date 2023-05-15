<?php

namespace App\Http\Controllers\Parent\Api;

use App\Actions\Claims\CalculateClaimsArrayAction;
use App\Actions\Claims\UpdateFixedClaimIfMenuExistsAction;
use App\Http\Controllers\BillingoController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\LunchOrderRequest;
use App\Mail\PartnerIdRewokedReportForAdmin;
use App\Mail\PartnerIdRewokedReportForParent;
use App\Models\BillingoData;
use App\Models\Lunch;
use App\Models\Merchant;
use App\Models\PartnerId;
use App\Models\PendingTransaction;
use App\Models\PeriodicLunch;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OrderLunchController extends Controller
{
    public function availableOrders(Request $request): JsonResponse
    {
        $student_id = $request->route('student_id');
        $orders = PeriodicLunch::where('student_id', $student_id)->get();

        return response()->json(['orders' => $orders]);
    }

    public function billingoConnectionStatus(Request $request): JsonResponse
    {
        // Getting billingo data to check billingo_suspended for Merchant (check that everything is good from merchant side)
        $merchantId = Lunch::where('id', $request->lunch_id)->first()->merchant_id;
        $billingoData = BillingoData::where('merchant_id', $merchantId)->first();
        $merchant = Merchant::where('id', $merchantId)->first();
        // Getting partner id to check billingo_suspended for Parent (check that everything is good from parent side)
        $partnerId = PartnerId::where('user_id', auth()->user()->id)->where('merchant_id', $merchantId)->first();

        // Run function to check PartnerId connection with billingo (parent-s connection with billingo to send invoice correctly)
        $this->checkUserPartnerIdConnection($partnerId);

        // billingo_suspended json response will be false no matter what if at least one (PartnerId suspend or BillingoData suspend is false)
        $conclusion = null;
        if ($billingoData->billingo_suspended || $partnerId->billingo_suspended) {
            $conclusion = 1;
        } elseif (! $billingoData->billingo_suspended && ! $partnerId->billingo_suspended) {
            $conclusion = 0;
        }

        // Generate the message which will tell to user what happens on which side (from which side the problem was detected)
        $message = null;
        if ($partnerId->billingo_suspended && $billingoData->billingo_suspended) {
            $message = 'Not available at the moment, both connections (your and '.$merchant->merchant_nick.') is bad with Billingo, try to reaload page or please wait until we fix this';
        } elseif ($partnerId->billingo_suspended) {
            $message = 'Not available at the moment, please try to reload page or wait until your Billingo connection will fix its Partner ID';
        } elseif ($billingoData->billingo_suspended) {
            $message = 'Not available at the moment, please wait until '.$merchant->merchant_nick.' will fix it, or try to reload page';
        }

        if ($message === null) {
            return response()->json(['billingo_suspended' => $conclusion]);
        }

        return response()->json(['billingo_suspended' => $conclusion, 'message' => $message]);
    }

    public static function checkUserPartnerIdConnection($partnerId): void
    {
        $merchantBillingoData = BillingoData::where('merchant_id', $partnerId->merchant_id)->first();
        $response = Http::withHeaders([
            'X-API-KEY' => $merchantBillingoData->billingo_api_key,
        ])->get('https://api.billingo.hu/v3/partners/'.$partnerId->partner_id);

        if ($response->status() === 200) {
            $partnerId->update([
                'billingo_suspended' => false,
            ]);
        }
        if ($response->status() === 403) {
            // partner_id is forbidden, probably revoked or incorrect
            $user = User::where('id', $partnerId->user_id)->first();
            $partnerId->update([
                'billingo_suspended' => true,
            ]);
            BillingoController::createOrUpdateParentBillingo($user->id);
            Mail::to('info@pupilpay.hu')->send(new PartnerIdRewokedReportForAdmin($user));
            Mail::to($user->email)->send(new PartnerIdRewokedReportForParent($user, $user->language));
            $partnerId->update([
                'billingo_suspended' => false,
            ]);
        }
        if ($response->status() === 500) {
            $partnerId->update([
                'billingo_suspended' => true,
            ]);
        }
    }

    public function orderLunch(LunchOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $student = Student::where('id', $validated['student_id'])->first();
        $pricePeriod = Lunch::where('id', $validated['lunch_id'])->first()->price_period;
        $lunch = Lunch::where('id', $validated['lunch_id'])->first();

        $claimsArray = CalculateClaimsArrayAction::execute([
            'claims' => $validated['claim_days'],
            'claimables' => $validated['claimables'],
        ]);

        DB::transaction(function () use ($student, $validated, $claimsArray, $pricePeriod, $lunch) {
            $pending_transaction = PendingTransaction::create([
                'user_id' => $student->user_id,
                'student_id' => $student->id,
                'merchant_id' => $lunch->merchant_id,
                'transaction_identifier' => 'here_should_be_some_hash',
                'transaction_date' => now()->format('Y-m-d'),
                'transaction_amount' => $validated['price'],
                'transaction_type' => 'payment',
                'comments' => json_encode([
                    'comment' => 'Placed lunch order on '.now()->format('Y-m-d'),
                    'comment_history' => [],
                ]),
                'history' => json_encode([
                    'history' => [],
                ]),
                'payment_method' => 'bank_transfer',
                'billing_type' => 'proforma',
                'billing_items' => json_encode([
                    'name' => 'Test lunch '.$claimsArray['claimDates'][0].' - '.$claimsArray['claimDates'][count($claimsArray['claimDates']) - 1],
                    'unit_price' => $pricePeriod,
                    'unit_price_type' => 'gross',
                    'quantity' => 1,
                    'unit' => 'db',
                    'vat' => '27%',
                ]),
                'convert_to_invoice' => true,
                'billing_provider' => 'billingo',
                'billing_comment' => json_encode([
                    'comment' => 'hardcoded billing comment',
                ]),
            ]);

            $lunch = PeriodicLunch::create([
                'student_id' => $student->id,
                'pending_transaction_id' => $pending_transaction->id,
                'merchant_id' => $lunch->merchant_id,
                'lunch_id' => $validated['lunch_id'],
                'card_data' => 'hardcoded instead of $student->card_data',
                'start_date' => reset($claimsArray['claimDates']),
                'end_date' => end($claimsArray['claimDates']),
                'claims' => json_encode($claimsArray['claimJson']),
            ]);

            // updates fixed claims if we have menu and after this we are ordering lunch
            UpdateFixedClaimIfMenuExistsAction::execute($validated);

            BillingoController::providePendingTransactionToBillingo($pending_transaction);

            if (! $pending_transaction || ! $lunch) {
                DB::rollBack();
            }
        });

        return response()->json(['success' => 'success']);
    }
}
