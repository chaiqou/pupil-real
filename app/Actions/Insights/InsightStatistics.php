<?php

namespace App\Actions\Insights;

use App\Models\PendingTransaction;
use App\Models\Transaction;
use Carbon\Carbon;

class InsightStatistics
{
    public function activeStudents($students): array|string
    {
        $studentsWithActiveStatusThirty = [];
        foreach ($students as $student) {
            $pastThirtyDays = Carbon::now()->subDays(30)->startOfDay();
            $pendingTransactionsThirty = $student->pendingTransactions()
                ->whereBetween('transaction_date', [$pastThirtyDays, Carbon::now()->endOfMonth()->format('Y-m-d')])
                ->count();
            $transactionsThirty = $student->transactions()
                ->whereBetween('transaction_date', [$pastThirtyDays, Carbon::now()->endOfMonth()->format('Y-m-d')])
                ->count();
            $ordersThirty = $student->orders()
                ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->count();
            if ($pendingTransactionsThirty > 0 || $transactionsThirty > 0 || $ordersThirty > 0) {
                $studentsWithActiveStatusThirty[] = $student;
            }
        }
        $studentsWithActiveStatusSixty = [];
        foreach ($students as $student) {
            $pastSixtyDays = Carbon::now()->subDays(60)->startOfDay();
            $pendingTransactionsSixty = $student->pendingTransactions()
                ->whereBetween('transaction_date', [$pastSixtyDays, Carbon::now()->subDays(30)])
                ->count();
            $transactionsSixty = $student->transactions()
                ->whereBetween('transaction_date', [$pastSixtyDays, Carbon::now()->subDays(30)])
                ->count();
            $ordersSixty = $student->orders()
                ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->count();
            if ($pendingTransactionsSixty > 0 || $transactionsSixty > 0 || $ordersSixty > 0) {
                $studentsWithActiveStatusSixty[] = $student;
            }
        }

        $countedActiveStudentsThirty = count($studentsWithActiveStatusThirty);
        $countedActiveStudentsSixty = count($studentsWithActiveStatusSixty);
        if (! $countedActiveStudentsThirty || ! $countedActiveStudentsSixty) {
            return 'unavailable to calculate';
        }
        $difference = round((($countedActiveStudentsThirty - $countedActiveStudentsSixty) / $countedActiveStudentsSixty) * 100);

        return
        [
            'thirty' => $countedActiveStudentsThirty,
            'sixty' => $countedActiveStudentsSixty,
            'difference' => $difference,
        ];
    }

    public function averageTransactionValue($merchant): array|string
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

    public function pendingTransactionValue($merchant): array|string
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

    public function averageStudentWeeklySpending($merchant, $students): array|string
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
