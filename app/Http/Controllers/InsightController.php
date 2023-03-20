<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\PendingTransaction;
use App\Models\Transaction;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class InsightController extends Controller
{
    public function activeStudents(): JsonResponse
    {
        $user = auth()->user();
        $students = Student::where('school_id', $user->school_id)->with(['pendingTransactions', 'transactions', 'orders'])->get();
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
        $difference = round((($countedActiveStudentsThirty - $countedActiveStudentsSixty) / $countedActiveStudentsSixty) * 100);
        return response()->json(['thirty' => $countedActiveStudentsThirty, 'sixty' => $countedActiveStudentsSixty, 'difference' => $difference]);
    }

    public function averageTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $pastThirtyDays = Carbon::now()->subDays(30)->startOfDay();
        $transactionsThirty = Transaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$pastThirtyDays, Carbon::now()->endOfMonth()->format('Y-m-d')])
            ->get();
        $transactionAmountsThirty = [];
        if(!count($transactionAmountsThirty)) {
            return response()->json('no');
        }
        foreach($transactionsThirty as $transaction)
        {
           $transactionAmountsThirty[] = $transaction->transaction_amount;
        }
        $sumOfTransactionValuesThirty = array_sum($transactionAmountsThirty);
        $frequencyOfTransactionValuesThirty = count($transactionAmountsThirty);
        $avgTransactionsPastThirty = $sumOfTransactionValuesThirty/$frequencyOfTransactionValuesThirty;


        $pastSixtyDays = Carbon::now()->subDays(60)->startOfDay();
        $transactionsSixty = Transaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$pastSixtyDays, Carbon::now()->subDays(30)])
            ->get();
        $transactionAmountsSixty = [];
        foreach($transactionsSixty as $transaction)
        {
            $transactionAmountsSixty[] = $transaction->transaction_amount;
        }
        $sumOfTransactionValuesSixty = array_sum($transactionAmountsSixty);
        $frequencyOfTransactionValuesSixty = count($transactionAmountsSixty);
        $avgTransactionsPastSixty = $sumOfTransactionValuesSixty/$frequencyOfTransactionValuesSixty;
        $difference = round((($avgTransactionsPastThirty - $avgTransactionsPastSixty) / $avgTransactionsPastSixty) * 100);
        return response()->json(['thirty' => $avgTransactionsPastThirty, 'sixty' => $avgTransactionsPastSixty, 'difference' => $difference]);
    }

    public function pendingTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $pendingTransactions = PendingTransaction::where('merchant_id', $merchant->id)
            ->get();
        $pendingTransactionAmounts = [];
        $pendingTransactionDates = [];
        foreach($pendingTransactions as $transaction)
        {
            $pendingTransactionAmounts[] = $transaction->transaction_amount;
            $pendingTransactionDates[] = $transaction->transaction_date;
        }
        $sumOfTransactionValues = array_sum($pendingTransactionAmounts);

        $timestamps = array_map(function($date) {
            return strtotime($date);
        }, $pendingTransactionDates);

        $averageTimestamp = array_sum($timestamps) / count($timestamps);
        $averageDate = date('Y-m-d', $averageTimestamp);


        return response()->json(['total' => $sumOfTransactionValues, 'date' => $averageDate]);
    }
}
