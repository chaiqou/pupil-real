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
        $previousMonth = Carbon::now()->subMonth();
        $numberOfDaysPrevious = $previousMonth->daysInMonth;
        $numberOfDaysCurrent = Carbon::now()->day;

// Determine the number of days to use for initializing the array
        $numberOfDays = max($numberOfDaysPrevious, $numberOfDaysCurrent);
       //use this one if upper one will cause bugs $numberOfDays = $numberOfDaysPrevious >= $numberOfDaysCurrent ? $numberOfDaysPrevious : $numberOfDaysCurrent;

// Create an array with the specified number of days, initialized to zero
        $transactionsByDayPrevious = array_fill(0, $numberOfDays, 0);
        $transactionsByDayCurrent = array_fill(0, $numberOfDays, 0);

// Get the pending transactions for the previous month
        $pendingTransactionsPrevious = PendingTransaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$previousMonth->startOfMonth()->format('Y-m-d'), $previousMonth->endOfMonth()->format('Y-m-d')])
            ->get();

// Get the pending transactions for the current month
        $pendingTransactionsCurrent = PendingTransaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
            ->get();

// Loop through the pending transactions and update the corresponding day's value in the array
        foreach ($pendingTransactionsPrevious as $transaction) {
            $dayOfMonth = (int) Carbon::parse($transaction->transaction_date)->format('j') - 1; // Subtract 1 to get a zero-based index
            $transactionsByDayPrevious[$dayOfMonth] += $transaction->transaction_amount;
        }

        foreach ($pendingTransactionsCurrent as $transaction) {
            $dayOfMonth = (int) Carbon::parse($transaction->transaction_date)->format('j') - 1; // Subtract 1 to get a zero-based index
            $transactionsByDayCurrent[$dayOfMonth] += $transaction->transaction_amount;
        }

        $transactionsByMonth = [
            'previous' => $transactionsByDayPrevious,
            'current' => $transactionsByDayCurrent
        ];

        return response()->json($transactionsByMonth);
    }
}
