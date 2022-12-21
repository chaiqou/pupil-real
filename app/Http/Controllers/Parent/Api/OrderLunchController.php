<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Models\PeriodicLunch;
use App\Models\Student;
use Illuminate\Http\Request;

class OrderLunchController extends Controller
{
    public function index(Request $request)
    {

        dump($request->lunch_details);
        $student = Student::where('id', $request->student_id)->first();

        $lunch = PeriodicLunch::create([
            'student_id' => $student->id,
            'card_data' => $student->card_data,
            'transaction_id' => 123,
            'merchant_id' => $student->school_id,
        ]);

        return response()->json(['success' => 'success']);
    }
}
