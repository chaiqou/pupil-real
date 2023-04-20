<?php

namespace App\Actions\Insights;

use App\Models\Transaction;
use Carbon\Carbon;

class AverageTransactionAction
{
    public static function execute($merchant): array|string
    {
        $pastThirtyDays = Carbon::now()->subDays(30)->startOfDay();
        $transactionsThirty = Transaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$pastThirtyDays, Carbon::now()->endOfMonth()->format('Y-m-d')])
            ->get();
        $transactionAmountsThirty = [];

        $pastSixtyDays = Carbon::now()->subDays(60)->startOfDay();
        $transactionsSixty = Transaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$pastSixtyDays, Carbon::now()->subDays(30)])
            ->get();

        if (! count($transactionsThirty) || ! count($transactionsSixty)) {
            return 'unavailable to calculate';
        }

        foreach ($transactionsThirty as $transaction) {
            $transactionAmountsThirty[] = $transaction->transaction_amount;
        }
        $sumOfTransactionValuesThirty = array_sum($transactionAmountsThirty);
        $frequencyOfTransactionValuesThirty = count($transactionAmountsThirty);
        $avgTransactionsPastThirty = $sumOfTransactionValuesThirty / $frequencyOfTransactionValuesThirty;

        $transactionAmountsSixty = [];
        foreach ($transactionsSixty as $transaction) {
            $transactionAmountsSixty[] = $transaction->transaction_amount;
        }
        $sumOfTransactionValuesSixty = array_sum($transactionAmountsSixty);
        $frequencyOfTransactionValuesSixty = count($transactionAmountsSixty);
        $avgTransactionsPastSixty = $sumOfTransactionValuesSixty / $frequencyOfTransactionValuesSixty;
        $difference = round((($avgTransactionsPastThirty - $avgTransactionsPastSixty) / $avgTransactionsPastSixty) * 100);

        return
            [
                'thirty' => $avgTransactionsPastThirty,
                'sixty' => $avgTransactionsPastSixty,
                'difference' => $difference,
            ];

    }
}
