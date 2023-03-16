<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class InsightController extends Controller
{
//    public function activeStudents(Request $request)
//    {
//        $currentMonth = Carbon::now();
//        $previousMonth = $currentMonth->copy()->subMonth();
//        $user = auth()->user();
//        $students = Student::where('school_id', $user->school_id)->with(['pendingTransactions', 'transactions', 'orders'])->get();
//        $studentsWithActiveStatus = [];
//        foreach($students as $student) {
//            if(count($student->pendingTransactions) || count($student->transactions) || count($student->orders))
//            {
//                $student->pendingTransactions
//                    ->whereBetween('transaction_date', [$previousMonth->startOfMonth()->format('Y-m-d'), $previousMonth->endOfMonth()->format('Y-m-d')])
//                    ->get();
//                $studentsWithActiveStatus[] = $student;
//               // array_push($pending, $studentsWithActiveStatus);
//            }
//        }
//        return response()->json($studentsWithActiveStatus);
//    }

    public function activeStudents(): JsonResponse
    {
        $user = auth()->user();
        $students = Student::where('school_id', $user->school_id)->with(['pendingTransactions', 'transactions', 'orders'])->get();
        $studentsWithActiveStatus = [];
        foreach ($students as $student) {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $pendingTransactions = $student->pendingTransactions()
                ->whereBetween('transaction_date', [$startDate, Carbon::now()->endOfMonth()->format('Y-m-d')])
                ->count();
            $transactions = $student->transactions()
                ->whereBetween('transaction_date', [$startDate, Carbon::now()->endOfMonth()->format('Y-m-d')])
                ->count();
            $orders = $student->orders()
                ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->count();
            if ($pendingTransactions > 0 || $transactions > 0 || $orders > 0) {
                $studentsWithActiveStatus[] = $student;
            }
        }
        $studentsWithActiveStatus2 = [];
        foreach ($students as $student) {
            $startDate2 = Carbon::now()->subDays(60)->startOfDay();
            $pendingTransactions2 = $student->pendingTransactions()
                ->whereBetween('transaction_date', [$startDate2, Carbon::now()->subDays(30)])
                ->count();
            $transactions2 = $student->transactions()
                ->whereBetween('transaction_date', [$startDate2, Carbon::now()->subDays(30)])
                ->count();
            $orders2 = $student->orders()
                ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->count();
            if ($pendingTransactions2 > 0 || $transactions2 > 0 || $orders2 > 0) {
                $studentsWithActiveStatus2[] = $student;
            }
        }

        $countedActiveStudents = count($studentsWithActiveStatus);
        $countedActiveStudents2 = count($studentsWithActiveStatus2);
        $difference = (($countedActiveStudents - $countedActiveStudents2) / $countedActiveStudents2) * 100;
        return response()->json(['thirty' => $countedActiveStudents, 'sixty' => $countedActiveStudents2, 'difference' => $difference]);
    }
}
