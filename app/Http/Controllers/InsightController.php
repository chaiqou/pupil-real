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
            $activeStatus = false;
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $pendingTransactions = $student->pendingTransactions()
                ->where('transaction_date', '<=', $startDate)
                ->count();
            $transactions = $student->transactions()
                ->where('transaction_date', '<=', $startDate)
                ->count();
            $orders = $student->orders()
                ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->count();
            if ($pendingTransactions > 0 || $transactions > 0 || $orders > 0) {
                $activeStatus = true;
            }
            if ($activeStatus) {
                $studentsWithActiveStatus[] = $student;
            }
        }
        $studentsWithActiveStatus2 = [];
        $students2 = Student::where('school_id', $user->school_id)->with(['pendingTransactions', 'transactions', 'orders'])->get();
        foreach ($students2 as $student) {
            $activeStatus2 = false;
            $startDate2 = Carbon::now()->subDays(60)->startOfDay();
            $pendingTransactions2 = $student->pendingTransactions()
                ->where('transaction_date', '<=', $startDate2)
                ->count();
            $transactions2 = $student->transactions()
                ->where('transaction_date', '<=', $startDate2)
                ->count();
            $orders2 = $student->orders()
                ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->count();
            if ($pendingTransactions2 > 0 || $transactions2 > 0 || $orders2 > 0) {
                $activeStatus2 = true;
            }
            if ($activeStatus2) {
                $studentsWithActiveStatus2[] = $student;
            }
        }
        return response()->json([$studentsWithActiveStatus, $studentsWithActiveStatus2]);
    }
}
