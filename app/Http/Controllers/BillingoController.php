<?php

namespace App\Http\Controllers;

use App\Http\Controllers\School\Api\TransactionController;
use App\Http\Requests\Invite\BillingoVerificationRequest;
use App\Http\Resources\PendingTransactionResource;
use App\Models\BillingoData;
use App\Models\Invite;
use App\Models\Merchant;
use App\Models\PartnerId;
use App\Models\PendingTransaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class BillingoController extends Controller
{
    public function submitBillingoVerify(BillingoVerificationRequest $request): RedirectResponse
    {
        $requestBillingo = Http::withHeaders([
            'X-API-KEY' => $request->api_key,
        ])->get('https://api.billingo.hu/v3/utils/time');
        $requestBillingoForBlockId = Http::withHeaders([
            'X-API-KEY' => $request->api_key,
        ])->get('https://api.billingo.hu/v3/document-blocks?page=1&per_page=25&type=invoice')->json();

        if ($requestBillingo->status() === 401) {
            return redirect()->back()->withErrors('You provided wrong API key');
        }
        if ($requestBillingo->status() === 402) {
            return redirect()->back()->withErrors("You dont have an active Billingo's subscription");
        }
        if ($requestBillingo->status() === 500) {
            return redirect()->back()->withErrors("Something went wrong at Billingo's side");
        }
        if ($requestBillingo->status() === 200) {
            $invite = Invite::where('uniqueID', request()->uniqueID)->first();
            $user = User::where('email', $invite->email)->first();
            $merchant = Merchant::where('user_id', $user->id)->first();
            $invite->update(['state' => 7]);
            BillingoData::create([
                'block_id' => $requestBillingoForBlockId['data'][0]['id'],
                'billingo_api_key' => $request->api_key,
                'merchant_id' => $merchant->id,
            ]);
            $merchant->update(['billingo_api_key' => $request->api_key]);

            return $user->sendVerificationEmail('merchant-verify.email');
        } else {
            return redirect()->back()->withErrors("Something went wrong from pupilpay's side");
        }
    }

    public static function createParentBillingo($user_id): void
    {
        $user = User::where('id', $user_id)->first();
        $merchants = Merchant::where('school_id', $user->school_id)->where('finished_onboarding', true)->get();
        $info = json_decode($user->user_information);
        foreach ($merchants as $merchant) {
            $billingoData = BillingoData::where('merchant_id', $merchant->id)->first();
            $requestBillingo = Http::withHeaders([
                'X-API-KEY' => $billingoData->billingo_api_key,
            ])->post('https://api.billingo.hu/v3/partners', [
                'name' => $user->middle_name ? $user->last_name.' '.$user->first_name.' '.$user->middle_name : $user->last_name.' '.$user->first_name,
                'address' => [
                    'country_code' => $info->country,
                    'post_code' => $info->zip,
                    'city' => $info->city,
                    'address' => $info->street_address,
                ],
                'emails' => [
                    $user->email,
                ],
            ])->json();
            PartnerId::create([
                'partner_id' => $requestBillingo['id'],
                'user_id' => $user->id,
                'merchant_id' => $merchant->id,
            ]);
        }
    }

    public static function providePendingTransactionToBillingo(PendingTransaction $pending_transaction): PendingTransactionResource
    {
        $user = User::where('id', auth()->user()->id)->first();
        $partner = PartnerId::where('user_id', $user->id)->first();
        $transactionBillingItem = json_decode($pending_transaction->billing_items);
        $merchant = Merchant::where('id', $pending_transaction->merchant_id)->first();
        $transaction_date = $pending_transaction->transaction_date;
        $transaction_date = strtotime($transaction_date);
        $transaction_date = strtotime('+7 days', $transaction_date);
        $transaction_due_date = date('Y-m-d', $transaction_date);
        $billingoData = BillingoData::where('merchant_id', $merchant->id)->first();
        $request = Http::withHeaders([
            'X-API-KEY' => $billingoData->billingo_api_key,
        ])->post('https://api.billingo.hu/v3/documents', [
            'partner_id' => $partner->partner_id,
            'block_id' => $billingoData->block_id,
            'type' => $pending_transaction->billing_type,
            'fulfillment_date' => $pending_transaction->transaction_date,
            'due_date' => $transaction_due_date,
            'payment_method' => 'wire_transfer',
            'language' => 'en',
            'currency' => 'HUF',
            'items' => [
                [
                    'name' => $transactionBillingItem->name,
                    'unit_price' => $transactionBillingItem->unit_price,
                    'unit_price_type' => $transactionBillingItem->unit_price_type,
                    'quantity' => $transactionBillingItem->quantity,
                    'unit' => $transactionBillingItem->unit,
                    'vat' => $transactionBillingItem->vat,
                    'comment' => $pending_transaction->billing_comment,
                ], ],
            'settings' => [
                'should_send_email' => true,
            ],
        ])->json();
        $pending_transaction->update([
            'proforma_id' => $pending_transaction->billing_type === 'proforma' ? $request['id'] : 'none',
        ]);
        $transactionComment = json_decode($pending_transaction->comments);
        $transactionComment->comment_history[] = $transactionComment->comment;
        $transactionComment->comment =
            'Issued'.' '.ucfirst($pending_transaction->billing_type).' on '.now()->format('Y-m-d').' ('.$request['invoice_number'].')';
        TransactionController::updateComment($pending_transaction, $transactionComment->comment);

        return new PendingTransactionResource($pending_transaction);
    }


    public static function createBillingDocument(string $api_key, int $partner_id, int $block_id, string $type, string $fulfillment_date,
    string $payment_method, string $language, string $currency, string $name, int $unit_price, string $unit_price_type, int $quantity,
    string $unit, string $vat, string $billing_comment, bool $should_send_email
    ): JsonResponse
    {
        $date = strtotime($fulfillment_date);
        $date = strtotime('+7 days', $date);
        $due_date = date('Y-m-d', $date);
        $request = Http::withHeaders([
            'X-API-KEY' => $api_key,
        ])->post('https://api.billingo.hu/v3/documents', [
            'partner_id' => $partner_id,
            'block_id' => $block_id,
            'type' => $type,
            'fulfillment_date' => $fulfillment_date,
            'due_date' => $due_date,
            'payment_method' => $payment_method,
            'language' => $language,
            'currency' => $currency,
            'items' => [
                [
                    'name' => $name,
                    'unit_price' => $unit_price,
                    'unit_price_type' => $unit_price_type,
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'vat' => $vat,
                    'comment' => $billing_comment,
                ], ],
            'settings' => [
                'should_send_email' => $should_send_email,
            ],
        ])->json();
        return response()->json($request);
    }

    public static function getBillingDocument(int $documentId, string $api_key): JsonResponse
    {
        $request =  Http::withHeaders([
            'X-API-KEY' => $api_key,
        ])->get('https://api.billingo.hu/v3/documents/'.$documentId)->json();
        return response()->json($request);
    }

    public static function proformaToInvoice($document, string $api_key, $billing_comment): JsonResponse
    {
        Http::withHeaders([
            'X-API-KEY' => $api_key,
        ])->post('https://api.billingo.hu/v3/documents/'.$document['id'].'/create-from-proforma', [
            'document_type' => 'invoice',
            'fulfillment_date' => $document['fulfillment_date'],
            'due_date' => $document['due_date'],
            'document_format' => '',
            'comment' => $billing_comment,
            'settings' => [
                'should_send_email' => true,
            ],
        ])->json();

        return response()->json('Invoice successfully created');
    }
}
