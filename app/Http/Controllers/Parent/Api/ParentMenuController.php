<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Models\LunchMenu;
use App\Models\PeriodicLunch;
use Illuminate\Http\Request;

class ParentMenuController extends Controller
{
    public function menuRetrieve(Request $request)
    {
        $studentId = request('student_id');

        $periodic_lunch = PeriodicLunch::where('student_id', $studentId)->pluck('lunch_id');
        $menu = LunchMenu::whereIn('lunch_id', $periodic_lunch)->get();

        return $menu;
    }
}
