<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\TransactionRequest;
use App\Http\Resources\parent\StudentResource;
use App\Http\Resources\TransactionResource;
use App\Models\Student;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ParentController extends Controller
{
    public function getTransactions(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        $transactions = Transaction::where('student_id', $request->student_id)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastWeekTransactionsSpending(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        $date = Carbon::now()->subWeeks();
        $transactions = Transaction::where('student_id', $request->student_id)->where('transaction_date', '>=', $date)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastMonthTransactionsSpending(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        $date = Carbon::now()->subMonths();
        $transactions = Transaction::where('student_id', $request->student_id)->where('transaction_date', '>=', $date)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastFiveTransactions(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        $transactions = Transaction::where('student_id', $request->student_id)->orderBy('transaction_date', 'desc')->take(5)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }
}
