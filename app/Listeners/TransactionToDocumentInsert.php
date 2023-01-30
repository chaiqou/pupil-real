<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Http\Controllers\School\Api\TransactionController;
use App\Models\BillingoData;
use App\Models\Merchant;
use App\Models\PartnerId;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class TransactionToDocumentInsert
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $partner = PartnerId::where('user_id', $user->id)->first();
        $transactionBillingItem = json_decode($event->transaction->billing_items);
        $merchant = Merchant::where('id', $event->transaction->merchant_id)->first();
        $transaction_date = $event->transaction->transaction_date;
        $transaction_date = strtotime($transaction_date);
        $transaction_date = strtotime('+7 days', $transaction_date);
        $transaction_due_date = date('Y-m-d', $transaction_date);
        $billingoData = BillingoData::where('merchant_id', $merchant->id)->first();
        $request = Http::withHeaders([
            'X-API-KEY' => $billingoData->billingo_api_key,
        ])->post('https://api.billingo.hu/v3/documents', [
            'partner_id' => $partner->partner_id,
            'block_id' => $billingoData->block_id,
            'type' => $event->transaction->billing_type,
            'fulfillment_date' => $event->transaction->transaction_date,
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
                    'comment' => $event->transaction->billing_comment,
                ], ],
            'settings' => [
                'should_send_email' => true,
            ],
        ])->json();
        $event->transaction->update([
            'billingo_proforma_id' => $event->transaction->billing_type === 'proforma' ? $request['id'] : null,
            'pending' => json_encode([
                'pending' => 1,
                'pending_status' => 'waiting_for_proforma_payment',
                'pending_history' => [],
            ]),
        ]);
        $transactionComment = json_decode($event->transaction->comment);
        $transactionComment->comment_history[] = $transactionComment->comment;
        $transactionComment->comment =
            'Issued'.' '.ucfirst($event->transaction->billing_type).' on '.now()->format('Y-m-d').' ('.$request['invoice_number'].')';
        TransactionController::updateComment($event->transaction->id, $transactionComment->comment);
    }
}
