<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Http\Controllers\Controller;
use App\Models\Lunch;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class MenuExportController extends Controller
{
    public function exportMenu(Request $request)
    {
        $weekNumber = $request[0]['week'];

        // Set the date to the first day of the given week number in the given year
        $date = CarbonImmutable::now()->startOfYear()->startOfWeek()->addWeeks($weekNumber);

        // Use the CarbonPeriod class to get all days in the week
        $weekDays = [];
        $period = CarbonPeriod::create($date->startOfDay(), $date->endOfWeek()->endOfDay());
        foreach ($period as $day) {
            $weekDays[] = $day->format('Y-m-d');
        }

        $startDate = $weekDays[0];
        $endDate = end($weekDays);

        // Find lunches which have a active range period between start and end date frontend data
        $lunches = Lunch::all();
        $filteredLunches = $lunches->filter(function ($lunch) use ($startDate, $endDate) {
            return $lunch->active_range[0] <= $endDate && $startDate <= $lunch->active_range[1];
        });
        dd($filteredLunches->all());

        return $weekDays;
    }
}
