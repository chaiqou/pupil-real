<?php

namespace App\Http\Controllers\Parent\Api;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\PeriodicLunch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\LunchOrderRequest;
use App\Models\Lunch;


class OrderLunchController extends Controller
{
    public function index(LunchOrderRequest $request)
    {
        $validate = $request->validated();
        $student = Student::where('id', $validate['student_id'])->first();

        // Validate the start date
        $startDate = Carbon::parse($validate['start_day']);

        // Filter the available dates array and take the first n elements
        $availableDates = array_filter($validate['available_days'], function ($date) use ($startDate) {
            return Carbon::parse($date)->gte($startDate);
        });

        $sortedAvailableDates = collect($availableDates)->sortBy(function ($item) {
            return Carbon::parse($item)->timestamp;
        });

        $sortedAvailableDates->splice($validate['period_length']);

        // Generates claims json for each days and also loops over claimables

        $claimsJson = [];

        foreach ($sortedAvailableDates as $date) {
            $claimables = [];

            foreach ($validate['claimables'] as $claimable) {
                $claimables[] = [
                    'name' => $claimable,
                    'claimed' => false,
                    'claimed_date' => null,
                ];
            }

            $claimsJson[$date] = $claimables;
        }
        $transaction = Transaction::create([
            'student_id' => $student->id,
            'merchant_id' => $student->school_id,
            'transaction_date' => Carbon::now(),
            'billingo_transaction_id' => null,
            'amount' => Lunch::where('id', $validate['lunch_id'])->first()->price_period,
            'transaction_type' => 'lunch',
            'pending' => json_encode(['pending' => true]),
            'comment' => json_encode(['comment' => 'Lunch']),
            'billing_items' => json_encode([
                [
                    'name' => 'Lunch',
                    'quantity' => 1,
                    'unit_price' => Lunch::where('id', $validate['lunch_id'])->first()->price_period,
                    'tax_rate' => 0,
                    'total' => Lunch::where('id', $validate['lunch_id'])->first()->price_period,
                ]
                ]),
        ]);

        DB::transaction(function () {
            $lunch = PeriodicLunch::create([
                'student_id' => $student->id,
                'transaction_id' => 1,
                'merchant_id' => $student->school_id,
                'lunch_id' => $validate['lunch_id'],
                'card_data' => $student->card_data,
                'start_date' => $sortedAvailableDates->first(),
                'end_date' => $sortedAvailableDates->last(),
                'claims' => json_encode($claimsJson),
            ]);

            Transaction::create([
                'student_id' => $student->id,
                'merchant_id' => $student->school_id,
                'transaction_date' => now()->format('Y-m-d'),
                'billingo_transaction_id' => null,
                'amount' => 1,
                'transaction_type' => 'debit',
                'billing_type' => 'proforma',
                'billing_comment' => 'billing_comment_here',
                'billing_items' => json_encode([
                    'name' => "Test lunch " . $sortedAvailableDates->first() . " - " . $sortedAvailableDates->last(),
                    "unit_price" => Lunch::where('id', $validate['lunch_id'])->first()->price_period,
                    "unit_price_type" => "gross",
                    "quantity" => 1,
                    "unit" => "db",
                    "vat" => "27%"
                ]),
                'pending' => json_encode([
                    'pending' => 0,
                    'pending_history' => [],
                ]),
                'comment' => json_encode([
                    'comment' => 'Placed lunch order on ' .now()->format('Y-m-d'),
                    'comment_history' => [],
                ]),
            ]);

        });


        return response()->json(['success' => 'success']);
    }
}
