<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invite\BillingoVerificationRequest;
use App\Models\BillingoData;
use App\Models\Invite;
use App\Models\Merchant;
use App\Models\PartnerId;
use App\Models\Transaction;
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
            'X-API-KEY' => $request->api_key
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
            BillingoData::create([
                'block_id' => $requestBillingoForBlockId['data'][0]['id'],
                'billingo_api_key' => $request->api_key,
                'merchant_id' => $merchant->id,
            ]);
            $merchant->update(['billingo_api_key' => $request->api_key]);
            return redirect()->route('merchant-verify.email', ['uniqueID' => request()->uniqueID]);
        } else {
            return redirect()->back()->withErrors("Something went wrong from pupilpay's side");
        }
    }

    public static function createParentBillingo($user_id): RedirectResponse
    {
        $user = User::where('id', $user_id)->first();
        $merchants = Merchant::where('school_id', $user->school_id)->get();
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
        return redirect()->route('default')->with(['success' => true, 'success_title' => 'You created your account!', 'success_description' => 'You can now login to your account.']);
    }

    public static function onTransactionCreate(Transaction $transaction)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $partner = PartnerId::where('user_id', $user->id)->first();
        $transactionBillingItem = json_decode($transaction->billing_item);
        $exactTransaction = Transaction::where('merchant_id', $transaction->merchant_id)->where('user_id', auth()->user()->id)->first();
        $exactMerchant = Merchant::where('id', $exactTransaction->merchant_id)->first();
        $transaction_date = $transaction->transaction_date;
        $transaction_date = strtotime($transaction_date);
        $transaction_date = strtotime("+7 days", $transaction_date);
        $transaction_due_date = date('Y-m-d', $transaction_date);
            $billingoData = BillingoData::where('merchant_id', $exactMerchant->id)->first();
            $request = Http::withHeaders([
                'X-API-KEY' => $billingoData->billingo_api_key,
            ])->post('https://api.billingo.hu/v3/documents', [
                'partner_id' => $partner->partner_id,
                'block_id' => $billingoData->block_id,
                'type' => $transaction->billing_type,
                'fulfillment_date' => $transaction->transaction_date,
                'due_date' => $transaction_due_date,
                'payment_method' => "wire_transfer",
                'language' => "en",
                'currency' => "HUF",
                'items' => [
                    [
                  'name' => $transactionBillingItem->name,
                  'unit_price' => $transactionBillingItem->unit_price,
                  'unit_price_type' => $transactionBillingItem->unit_price_type,
                  'quantity' => $transactionBillingItem->quantity,
                  "unit" => $transactionBillingItem->unit,
                  "vat" => $transactionBillingItem->vat,
                  "comment" => $transaction->billing_comment,
                ]],
                'settings' => [
                    "should_send_email" => true,
                ]
            ])->json();

            dd($request);
        }

}
