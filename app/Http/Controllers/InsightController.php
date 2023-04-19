<?php

namespace App\Http\Controllers;

use App\Actions\Insights\InsightStatistics;
use App\Models\Merchant;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class InsightController extends Controller
{
    public function activeStudents(): JsonResponse
    {
        $user = auth()->user();
        $students = Student::where('school_id', $user->school_id)->with(['pendingTransactions', 'transactions', 'orders'])->get();

        $activeStudentsData = InsightStatistics::activeStudents($students);

        return response()->json($activeStudentsData);
    }

    public function averageTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $avgTransactionValueData = InsightStatistics::averageTransactionValue($merchant);

        return response()->json($avgTransactionValueData);
    }

    public function pendingTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $pendingTransactionValueData = InsightStatistics::pendingTransactionValue($merchant);

        return response()->json($pendingTransactionValueData);
    }

    public function averageStudentWeeklySpending(): JsonResponse
    {
        $user = auth()->user();
        $merchant = Merchant::where('user_id', $user->id)->first();
        $students = Student::where('school_id', $user->school_id)->count();
        $avgStudentWeeklySpendingData = InsightStatistics::averageStudentWeeklySpending($merchant, $students);

        return response()->json($avgStudentWeeklySpendingData);
    }
}
