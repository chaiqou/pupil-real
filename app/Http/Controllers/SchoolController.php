<?php

namespace App\Http\Controllers;

use App\Http\Requests\School\StudentRequest;
use App\Http\Requests\School\TransactionRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TransactionResource;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolController extends Controller
{
    public function getTransactions(TransactionRequest $request): ResourceCollection
    {
        $transactions = Transaction::where('merchant_id', $request->user_id)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getStudents(StudentRequest $request): ResourceCollection
    {
        $students = Student::where('school_id', $request->school_id)->with('user')->get();
        return StudentResource::collection($students);
    }
}
