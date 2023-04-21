<?php

namespace App\Actions\Insights;

use Carbon\Carbon;

class ActiveStudentsAction
{
    public static function execute($students): array|string
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
}
