<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;
use App\Actions\Insights\InsightStatistics;
use App\Actions\Insights\ActiveStudentsAction;
use App\Actions\Insights\AverageTransactionAction;
use App\Actions\Insights\PendingTransactionAction;
use App\Actions\Insights\StudentWeeklySpendingAction;

class InsightController extends Controller
{
    public function activeStudents(): JsonResponse
    {
        $user = auth()->user();
        $students = Student::where('school_id', $user->school_id)->with(['pendingTransactions', 'transactions', 'orders'])->get();

        $activeStudentsData = ActiveStudentsAction::execute($students);

        return response()->json($activeStudentsData);
    }

    public function averageTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $avgTransactionValueData = AverageTransactionAction::execute($merchant);

        return response()->json($avgTransactionValueData);
    }

    public function pendingTransactionValue(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $pendingTransactionValueData = PendingTransactionAction::execute($merchant);

        return response()->json($pendingTransactionValueData);
    }

    public function averageStudentWeeklySpending(): JsonResponse
    {
        $user = auth()->user();
        $merchant = Merchant::where('user_id', $user->id)->first();
        $students = Student::where('school_id', $user->school_id)->count();
        $avgStudentWeeklySpendingData = StudentWeeklySpendingAction::execute($merchant, $students);

        return response()->json($avgStudentWeeklySpendingData);
    }
}
