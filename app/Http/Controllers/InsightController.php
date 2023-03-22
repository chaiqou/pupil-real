<?php

namespace App\Http\Controllers;

use App\Actions\Insights\InsightStatistics;
use App\Models\Merchant;
use App\Models\PendingTransaction;
use App\Models\PeriodicLunch;
use App\Models\Transaction;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class InsightController extends Controller
{
    public function activeStudents(): JsonResponse
    {
        $pastThirtyDays = Carbon::now()->subDays(30)->startOfDay();
        $pendingTransactionsThirty = PendingTransaction::whereBetween('transaction_date', [$pastThirtyDays, Carbon::now()->endOfMonth()->format('Y-m-d')]);
        $transactionsThirty = Transaction::whereBetween('transaction_date', [$pastThirtyDays, Carbon::now()->endOfMonth()->format('Y-m-d')]);
        $orders = PeriodicLunch::where('end_date', '>=', Carbon::now()->format('Y-m-d'));

        $pastSixtyDays = Carbon::now()->subDays(60)->startOfDay();
        $pendingTransactionsSixty = PendingTransaction::whereBetween('transaction_date', [$pastSixtyDays, Carbon::now()->subDays(30)]);
        $transactionsSixty = Transaction::whereBetween('transaction_date', [$pastSixtyDays, Carbon::now()->subDays(30)]);

        $insightClass = new InsightStatistics();
        $activeStudentsData = $insightClass->activeStudents($pendingTransactionsThirty, $pendingTransactionsSixty, $transactionsThirty, $transactionsSixty, $orders);
        return response()->json($activeStudentsData);
    }

    public function averageTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $insightClass = new InsightStatistics();
        $avgTransactionValueData = $insightClass->averageTransactionValue($merchant);
        return response()->json($avgTransactionValueData);
    }

    public function pendingTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $insightClass = new InsightStatistics();
        $pendingTransactionValueData = $insightClass->pendingTransactionValue($merchant);
        return response()->json($pendingTransactionValueData);
    }

    public function averageStudentWeeklySpending(): JsonResponse
    {
        $user = auth()->user();
        $merchant = Merchant::where('user_id', $user->id)->first();
        $students = Student::where('school_id', $user->school_id)->count();
        $insightClass = new InsightStatistics();
        $avgStudentWeeklySpendingData = $insightClass->averageStudentWeeklySpending($merchant, $students);
        return response()->json($avgStudentWeeklySpendingData);
    }
}
