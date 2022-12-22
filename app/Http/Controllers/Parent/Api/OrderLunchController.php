<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\LunchOrderRequest;
use App\Models\PeriodicLunch;
use App\Models\Student;
use Carbon\Carbon;

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

             $sortedAvailableDates =  collect($availableDates)->sortBy(function ($item) {
            return Carbon::parse($item)->timestamp;
        });

        dump($sortedAvailableDates);



        $lunch = PeriodicLunch::create([
            'student_id' => $student->id,
            'transaction_id' => 1,
            'merchant_id' => $student->school_id,
            'lunch_id' => $validate['lunch_id'],
            'card_data' => $student->card_data,
            'start_date' => $sortedAvailableDates->first(),
            'end_date' => $sortedAvailableDates->last(),
            'claims' => json_encode($availableDates),
        ]);

        return response()->json(['success' => 'success']);
    }
}
