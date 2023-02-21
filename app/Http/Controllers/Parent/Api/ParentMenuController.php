<?php

namespace App\Http\Controllers\Parent\Api;

use App\Models\LunchMenu;
use Illuminate\Http\Request;
use App\Models\PeriodicLunch;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ParentMenuController extends Controller
{
    public function menuRetrieve(Request $request): JsonResponse
    {
        $studentId = request('student_id');

        $periodic_lunch = PeriodicLunch::where('student_id', $studentId)->get();
        $periodic_lunch_ids = $periodic_lunch->pluck('id')->toArray();
        $menu = LunchMenu::whereIn('lunch_id',  $periodic_lunch_ids)->get();

        return response()->json(['menu' => $menu , 'lunch' => $periodic_lunch]);
    }


}
