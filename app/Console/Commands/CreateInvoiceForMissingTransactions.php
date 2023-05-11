<?php

namespace App\Console\Commands;

use App\Http\Controllers\BillingoController;
use App\Models\BillingoData;
use App\Models\PartnerId;
use App\Models\Transaction;
use App\Models\TransactionMissingAction;
use App\Models\User;
use Illuminate\Console\Command;

class CreateInvoiceForMissingTransactions extends Command
{
    protected $signature = 'portal:create-invoice-for-missing-transactions';

    protected $description = 'Creating an invoice for transactions which is missing its invoice due to Billingo api key of merchant was been suspended';

    public function handle()
    {
        $transactionMissingActions = TransactionMissingAction::where('completed', 0)->get();
        foreach ($transactionMissingActions as $transactionMissingAction) {
            $transaction = Transaction::where('id', $transactionMissingAction->transaction_id)->first();
            $merchantBillingoData = BillingoData::where('merchant_id', $transaction->merchant_id)->first();
            $partnerId = PartnerId::where('user_id', $transaction->user_id)->where('merchant_id', $transaction->merchant_id)->first();
            $transactionBillingItems = json_decode($transaction->billing_items);
            $transactionComment = json_decode($transaction->billing_comment);
            $user = User::where('id', $partnerId->user_id)->first();
            if (! $merchantBillingoData->billingo_suspended) {
                BillingoController::createBillingDocument($merchantBillingoData->billingo_api_key, $partnerId->partner_id, $merchantBillingoData->block_id,
                    'invoice', $transaction->transaction_date, 'online_bankcard', $user->language,
                    'HUF', $transactionBillingItems->name, $transactionBillingItems->unit_price, $transactionBillingItems->unit_price_type,
                    $transactionBillingItems->quantity, $transactionBillingItems->unit, $transactionBillingItems->vat, $transactionComment->comment, true);
                $this->info('Invoice from merchant which id is #'.$merchantBillingoData->merchant_id.' is successfully sent for parent which id is #'.$user->id);
            } else {
                $this->info('Merchant data of merchant with id #'.$merchantBillingoData->merchant_id.' is still suspended, can not send an invoice, please provide correct api key');
            }
        }
    }
}
