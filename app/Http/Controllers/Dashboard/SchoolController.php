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
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolController extends Controller
{
    public function getTransactions(Request $request): ResourceCollection|JsonResponse
    {
            $transactions = Transaction::where('merchant_id', $request->school_id)->with('merchant', 'student')->latest('created_at')->paginate(6);
            return TransactionResource::collection($transactions);
    }

    public function getStudents(Request $request): ResourceCollection|JsonResponse
    {
            $students = Student::where('school_id', $request->school_id)->with('user')->latest('created_at')->paginate(6);
            return StudentResource::collection($students);
    }

    public function getDashboardStudents(Request $request): ResourceCollection|JsonResponse
    {
            $merchant = Merchant::where('user_id', $request->school_id)->first();
            $students = Student::where('school_id', $merchant->id)->with('user')->latest('created_at')->paginate(6);
            return StudentResource::collection($students);
    }

    public function getLastFiveTransactions(Request $request): ResourceCollection|JsonResponse
    {
            $transactions = Transaction::where('merchant_id', $request->school_id)->orderBy('transaction_date', 'desc')->take(5)->with('merchant', 'student')->get();
            return TransactionResource::collection($transactions);
    }
}
