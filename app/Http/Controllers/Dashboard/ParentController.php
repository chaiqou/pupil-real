<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Parent\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Student;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function parentDashboard(): RedirectResponse|View
    {

        if(Auth::user()->hasRole('parent') && Auth::user()->students->count() > 1) {
            return view('layouts.select-students', ['students' =>  Auth::user()->students->all()]);
          } else  {
            return redirect()->route('parent.dashboard', ['student_id' => Auth::user()->students->first()->id]);
          }

    }

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
