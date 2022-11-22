<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionController extends Controller
{
    public function getTransactions(Request $request): ResourceCollection
    {
        $transactions = Transaction::where('student_id', $request->student_id)->with('merchant', 'student')->latest('created_at')->paginate(6);
        return TransactionResource::collection($transactions);
    }

    public function getLastWeekTransactionsSpending(Request $request): ResourceCollection
    {
        $date = Carbon::now()->subWeeks();
        $transactions = Transaction::where('student_id', $request->student_id)->where('transaction_date', '>=', $date)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastMonthTransactionsSpending(Request $request): ResourceCollection
    {
        $date = Carbon::now()->subMonths();
        $transactions = Transaction::where('student_id', $request->student_id)->where('transaction_date', '>=', $date)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastFiveTransactions(Request $request): ResourceCollection
    {
        $transactions = Transaction::where('student_id', $request->student_id)->orderBy('transaction_date', 'desc')->take(5)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }
}
