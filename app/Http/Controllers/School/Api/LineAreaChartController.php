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
        $currentMonth = Carbon::now();
        $previousMonth = $currentMonth->copy()->subMonth();
        $numberOfDaysPrevious = $previousMonth->daysInMonth;
        $numberOfDaysCurrent = $currentMonth->daysInMonth;

// Determine the number of days to use for initializing the arrays
        $numberOfDays = $numberOfDaysCurrent;
        if ($numberOfDaysPrevious < $numberOfDaysCurrent) {
            $numberOfDays = $numberOfDaysPrevious;
        }

// Create arrays with the specified number of days, initialized to zero
        $transactionsByDayPrevious = array_fill(0, $numberOfDaysPrevious, 0);
       // $transactionsByDayCurrent = array_fill(0, $numberOfDaysCurrent, 0);
        $transactionsByDayCurrent = array_fill(0, $numberOfDaysPrevious, 0);
        if ($numberOfDaysCurrent < $numberOfDaysPrevious) {
            $transactionsByDayCurrent = array_slice($transactionsByDayCurrent, 0, $numberOfDaysPrevious);
        }

        //Calculate the tomorrow day index to find the index of next day into the array
        $tomorrow_day_index = (int)date('j', strtotime('+1 days')) - 1;
        //Calculate the formula and fill only the days after today
        for ($i = $tomorrow_day_index; $i < count($transactionsByDayCurrent); $i++) {
            $transactionsByDayCurrent[$i] = null;
        }



// Get the pending transactions for the previous month
        $pendingTransactionsPrevious = PendingTransaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [$previousMonth->startOfMonth()->format('Y-m-d'), $previousMonth->endOfMonth()->format('Y-m-d')])
            ->get();

// Get the pending transactions for the current month
        $pendingTransactionsCurrent = PendingTransaction::where('merchant_id', $merchant->id)
            ->whereBetween('transaction_date', [Carbon::now()->startOfMonth()->format('Y-m-d'), $currentMonth->format('Y-m-d')])
            ->get();


// Nothing if transactions for previous or current month is not found by the way we need for the calculations below
        if(!count($pendingTransactionsPrevious) || !count($pendingTransactionsCurrent))
        {
            return response()->json('Nothing is found');
        }

// Loop through the pending transactions and update the corresponding day's value in the array
        foreach ($pendingTransactionsPrevious as $transaction) {
            $dayOfMonth = (int) Carbon::parse($transaction->transaction_date)->format('j') - 1; // Subtract 1 to get a zero-based index
            $transactionsByDayPrevious[$dayOfMonth] += $transaction->transaction_amount;
        }

        foreach ($pendingTransactionsCurrent as $transaction) {
            $dayOfMonth = (int) Carbon::parse($transaction->transaction_date)->format('j') - 1; // Subtract 1 to get a zero-based index

            if ($dayOfMonth >= $numberOfDays) {
                break;
            }

            $transactionsByDayCurrent[$dayOfMonth] += $transaction->transaction_amount;
        }

        $transactionsByDayPrediction = array_fill(0, $numberOfDaysPrevious, 0);
        if ($numberOfDaysCurrent < $numberOfDaysPrevious) {
            $transactionsByDayPrediction = array_slice($transactionsByDayPrediction, 0, $numberOfDaysPrevious);
        }


        $sumsOfCurrent = [];
        $runningSumOfCurrent = 0;
        foreach ($transactionsByDayCurrent as $value) {
            $runningSumOfCurrent += $value;
            $sumsOfCurrent[] = $runningSumOfCurrent;
        }

        $sumsOfPrevious = [];
        $runningSumOfPrevious = 0;
        foreach ($transactionsByDayPrevious as $value) {
            $runningSumOfPrevious += $value;
            $sumsOfPrevious[] = $runningSumOfPrevious;
        }
        $averagePrevious = array_sum($transactionsByDayPrevious) / count($transactionsByDayPrevious);
        $averageCurrent = array_sum($transactionsByDayCurrent) / count($transactionsByDayCurrent);
        $difference = (($averageCurrent * 100) / $averagePrevious) / 100;
        $transactionsByDayPrediction[$tomorrow_day_index - 1] = end($sumsOfCurrent);
//Calculate the formula and fill only the days after today
        for ($i = $tomorrow_day_index; $i < count($transactionsByDayPrediction); $i++) {
            $transactionsByDayPrediction[$i] =  $transactionsByDayPrediction[$i-1] + ($transactionsByDayPrevious[$i] * $difference);
        }

//Replace all 0-s with nulls
        $transactionsByDayPrediction = array_map(function($value) {
            return ($value === 0) ? null : $value;
        }, $transactionsByDayPrediction);

        for ($i = $tomorrow_day_index; $i < count($sumsOfCurrent); $i++) {
            $sumsOfCurrent[$i] = null;
        }

        $transactionsByMonth = [
            'previous' => $sumsOfPrevious,
            'current' => $sumsOfCurrent,
            'prediction' => $transactionsByDayPrediction,
            $difference,
        ];

        return response()->json($transactionsByMonth);

    }
}




