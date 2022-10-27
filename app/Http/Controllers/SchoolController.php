<?php

namespace App\Http\Controllers;

use App\Http\Requests\School\StudentRequest;
use App\Http\Requests\School\TransactionRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TransactionResource;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolController extends Controller
{
    public function getTransactions(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        if(auth()->user()->hasRole('school'))
        {
            $transactions = Transaction::where('merchant_id', $request->user_id)->with('merchant', 'student')->get();
            return TransactionResource::collection($transactions);
        }
       return response()->json(['error' => 'To get this information you should be role of school and be authorized.']);
    }

    public function getStudents(StudentRequest $request): ResourceCollection|JsonResponse
    {
        if(auth()->user()->hasRole('school')) {
            $students = Student::where('school_id', $request->school_id)->with('user')->get();
            return StudentResource::collection($students);
        }
        return response()->json(['error' => 'To get this information you should be role of school and be authorized.']);
    }
}
