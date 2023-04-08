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

        $insightClass = new InsightStatistics();
        $activeStudentsData = $insightClass->activeStudents($students);

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
