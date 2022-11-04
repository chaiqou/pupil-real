<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\StudentRequest;
use App\Http\Requests\School\TransactionRequest;
use App\Http\Resources\School\StudentResource;
use App\Http\Resources\TransactionResource;
use App\Models\Merchant;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolController extends Controller
{
    public function getTransactions(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        if (auth()->user()->hasRole('school')) {
            $transactions = Transaction::where('merchant_id', $request->school_id)->with('merchant', 'student')->get();

            return TransactionResource::collection($transactions);
        }

        return response()->json(['error' => 'To get this information you should be role of school and be authorized.']);
    }

    public function getStudents(StudentRequest $request): ResourceCollection|JsonResponse
    {
        if (auth()->user()->hasRole('school')) {
            $students = Student::where('school_id', $request->school_id)->with('user')->get();

            return StudentResource::collection($students);
        }

        return response()->json(['error' => 'To get this information you should be role of school and be authorized.']);
    }

    public function getDashboardStudents(StudentRequest $request): ResourceCollection|JsonResponse
    {
        if (auth()->user()->hasRole('school')) {
            $merchant = Merchant::where('user_id', $request->school_id)->first();
            $students = Student::where('school_id', $merchant->id)->with('user')->get();

            return StudentResource::collection($students);
        }

        return response()->json(['error' => 'To get this information you shoulb be role of school and be authorized.']);
    }

    public function getLastFiveTransactions(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        if (auth()->user()->hasRole('school')) {
            $transactions = Transaction::where('merchant_id', $request->school_id)->orderBy('transaction_date', 'desc')->take(5)->with('merchant', 'student')->get();

            return TransactionResource::collection($transactions);
        }

        return response()->json(['error' => 'To get this information you should be role of school and be authorized.']);
    }
}
