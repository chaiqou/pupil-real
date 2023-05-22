<?php

namespace App\Actions\Insights;

use App\Models\PendingTransaction;
use Carbon\Carbon;

class StudentWeeklySpendingAction
{
    public static function execute($merchant, $students): array|string
    {
        $currentMonth = Carbon::now();
        $previousMonth = $currentMonth->copy()->subMonth();
        $previousToPreviousMonth = $previousMonth->copy()->subMonth();
        $transactionsPreviousMonth = PendingTransaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$previousMonth->startOfMonth()->format('Y-m-d'), $previousMonth->endOfMonth()->format('Y-m-d')])
            ->get();
        $transactionsPreviousToPreviousMonth = PendingTransaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$previousToPreviousMonth->startOfMonth()->format('Y-m-d'), $previousToPreviousMonth->endOfMonth()->format('Y-m-d')])
            ->get();
        if (! count($transactionsPreviousMonth) || ! count($transactionsPreviousToPreviousMonth)) {
            return 'unavailable to calculate';
        }
        $transactionAmountPreviousMonth = [];
        $transactionAmountPreviousToPreviousMonth = [];
        foreach ($transactionsPreviousMonth as $transaction) {
            $transactionAmountPreviousMonth[] = $transaction->transaction_amount;
        }
        foreach ($transactionsPreviousToPreviousMonth as $transaction) {
            $transactionAmountPreviousToPreviousMonth[] = $transaction->transaction_amount;
        }
        $previousMonthDays = date('t', strtotime('-1 month'));
        $previousToPreviousMonthDays = date('t', strtotime('-2 month'));
        $sumOfAmountsPrevious = array_sum($transactionAmountPreviousMonth);
        $sumOfAmountsPreviousToPrevious = array_sum($transactionAmountPreviousToPreviousMonth);

        $avgPerStudentPreviousMonth = round(($sumOfAmountsPrevious / ($previousMonthDays / 7)) / $students);
        $avgPerStudentPreviousToPreviousMonth = round(($sumOfAmountsPreviousToPrevious / ($previousToPreviousMonthDays / 7)) / $students);

        $difference = round((($avgPerStudentPreviousMonth - $avgPerStudentPreviousToPreviousMonth) / $avgPerStudentPreviousToPreviousMonth) * 100);

        return
            [
                'previous' => $avgPerStudentPreviousMonth,
                'past' => $avgPerStudentPreviousToPreviousMonth,
                'difference' => $difference,
            ];
    }
}
