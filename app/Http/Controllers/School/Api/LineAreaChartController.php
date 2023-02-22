<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\PendingTransaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class LineAreaChartController extends Controller
{
    public function calculateChartInfo(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();

        $currentDate = Carbon::now();
        $previousMonth = $currentDate->subMonth();
        $numberOfDays = $previousMonth->daysInMonth;

// Create an array with the number of days in the previous month, initialized to zero
        $transactionsByDay = array_fill(0, $numberOfDays, 0);

// Get the pending transactions for the previous month
        $pendingTransactions = PendingTransaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$previousMonth->startOfMonth()->format('Y-m-d'), $previousMonth->endOfMonth()->format('Y-m-d')])
            ->get();

// Loop through the pending transactions and update the corresponding day's value in the array
        foreach ($pendingTransactions as $transaction) {
            $dayOfMonth = (int) Carbon::parse($transaction->transaction_date)->format('j') - 1; // Subtract 1 to get a zero-based index
            $transactionsByDay[$dayOfMonth] += $transaction->transaction_amount;
        }
        return response()->json($transactionsByDay);
    }
}
