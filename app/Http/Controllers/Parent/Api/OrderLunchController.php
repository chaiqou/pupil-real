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
        dump($validate);
        $student = Student::where('id', $validate['student_id'])->first();

        // Validate the start date
        $startDate = Carbon::parse($validate['start_day']);
        dump($startDate->toDateString());

        // Filter the available dates array and take the first n elements
        $availableDates = array_filter($validate['available_days'], function ($date) use ($startDate) {
            return Carbon::parse($date)->gte($startDate);
        });

        $availableDates = array_slice($availableDates, 0, $validate['period_length']);

        dump($availableDates);




        $lunch = PeriodicLunch::create([
            'student_id' => $student->id,
            'card_data' => $student->card_data,
            'transaction_id' => 123,
            'merchant_id' => $student->school_id,
        ]);

        return response()->json(['success' => 'success']);
    }
}
