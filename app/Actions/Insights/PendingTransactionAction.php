<?php

namespace App\Actions\Insights;

use App\Models\PendingTransaction;
use Carbon\Carbon;

class PendingTransactionAction
{
    public static function execute($merchant): array|string
    {
        $pendingTransactions = PendingTransaction::where('merchant_id', $merchant->id)
            ->get();
        $pendingTransactionAmounts = [];
        $pendingTransactionDates = [];

        if (! count($pendingTransactions)) {
            return 'unavailable to calculate';
        }

        foreach ($pendingTransactions as $transaction) {
            $pendingTransactionAmounts[] = $transaction->transaction_amount;
            $pendingTransactionDates[] = $transaction->transaction_date;
        }
        $sumOfTransactionValues = array_sum($pendingTransactionAmounts);

        $timestamps = array_map(function ($date) {
            return strtotime($date);
        }, $pendingTransactionDates);

        $averageTimestamp = array_sum($timestamps) / count($timestamps);
        $averageDate = date('Y-m-d', $averageTimestamp);
        $averageDateCarbon = Carbon::parse($averageDate);
        $averageDateAgeFormat = $averageDateCarbon->diffForHumans();

        return
         [
             'total' => $sumOfTransactionValues,
             'date' => $averageDateAgeFormat,
         ];
    }
}
