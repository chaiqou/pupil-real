<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\LunchOrderRequest;
use App\Models\Lunch;
use App\Models\PeriodicLunch;
use App\Models\Student;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class OrderLunchController extends Controller
{
    public function index(LunchOrderRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $student = Student::where('id', $validate['student_id'])->first();
        $pricePeriod = Lunch::where('id', $validate['lunch_id'])->first()->price_period;

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

        DB::transaction(function () use ($student, $validate, $sortedAvailableDates, $claimsJson, $pricePeriod) {
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
                'billing_item' => json_encode([
                    'name' => 'Test lunch '.$sortedAvailableDates->first().' - '.$sortedAvailableDates->last(),
                    'unit_price' => $pricePeriod,
                    'unit_price_type' => 'gross',
                    'quantity' => 1,
                    'unit' => 'db',
                    'vat' => '27%',
                ]),
                'pending' => json_encode([
                    'pending' => 0,
                    'pending_history' => [],
                ]),
                'comment' => json_encode([
                    'comment' => 'Placed lunch order on '.now()->format('Y-m-d'),
                    'comment_history' => [],
                ]),
            ]);
        });

        return response()->json(['success' => 'success']);
    }

    public function claims($lunch_id): Array
    {
        $claims = PeriodicLunch::where('lunch_id', $lunch_id)->select('claims')
        ->get();

        $dates = [];

        foreach ($claims as $item) {
            $claims = json_decode($item['claims'], true);
            $dates = array_merge(array_keys($claims));
        }


        return $dates;
    }
}
