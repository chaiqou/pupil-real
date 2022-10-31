<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Parent\CreateStudentRequest;
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
          } elseif(Auth::user()->hasRole('parent') && Auth::user()->students->count() === 1)  {
            return redirect()->route('parent.dashboard', ['student_id' => Auth::user()->students->first()->id]);
          } else {
            return redirect()->route('parent.create-student', ['user_id' => Auth::user()->id]);
        }
    }

    public function createStudent(): View
    {
        return view('parent.create-student', ['user_id' => Auth::user()->id], [
            'user_id' => auth()->user()->id,
        ]);
    }

    public function submitStudent(CreateStudentRequest $request): RedirectResponse
    {
       $user = auth()->user();
       Student::create([
           'user_id' => $user->id,
           'school_id' => $user->school_id,
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'middle_name' => $request->middle_name,
           'user_information' => [
               'country'  => $request->country,
               'street_address'   => $request->street_address,
               'city'  => $request->city,
               'state'   => $request->state,
               'zip'  => (int)$request->zip,
           ]
       ]);

        return redirect()->route('parent.create-student-verify', ['user_id' => auth()->user()->id]);
    }

    public function verifyStudentCreation(): view
    {
        return view('parent.create-student-verify', [
            'user_id' => auth()->user()->id
        ]);
    }

        public function getTransactions(TransactionRequest $request): ResourceCollection
    {
        $transactions = Transaction::where('student_id', $request->student_id)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastWeekTransactionsSpending(TransactionRequest $request): ResourceCollection
    {
        $date = Carbon::now()->subWeeks();
        $transactions = Transaction::where('student_id', $request->student_id)->where('transaction_date', '>=', $date)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastMonthTransactionsSpending(TransactionRequest $request): ResourceCollection
    {
        $date = Carbon::now()->subMonths();
        $transactions = Transaction::where('student_id', $request->student_id)->where('transaction_date', '>=', $date)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

    public function getLastFiveTransactions(TransactionRequest $request): ResourceCollection
    {
        $transactions = Transaction::where('student_id', $request->student_id)->orderBy('transaction_date', 'desc')->take(5)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }

}
