<?php

namespace App\Actions\Excel;

use App\Models\Lunch;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class FindExcelLunchesAction
{
    public static function execute(int $weekNumber): array
    {
        // Set the date to the first day of the given week number in the given year
        $date = CarbonImmutable::now()->startOfYear()->startOfWeek()->addWeeks($weekNumber);

        // Use the CarbonPeriod class to get all days in the week
        $weekDays = [];
        $period = CarbonPeriod::create($date->startOfDay(), $date->endOfWeek()->endOfDay());
        foreach ($period as $day) {
            $weekDays[] = $day->format('Y-m-d');
        }

        // Lunch Week Start and End day
        $startDate = $weekDays[0];
        $endDate = end($weekDays);

        // Find lunches which have a active range period between start and end date frontend data
        $lunches = Lunch::all();
        $filteredLunches = $lunches->filter(function ($lunch) use ($startDate, $endDate) {
            return $lunch->active_range[0] <= $endDate && $startDate <= $lunch->active_range[1];
        })->all();

        return [
            'weekDays' => $weekDays,
            'filteredLunches' => $filteredLunches,
        ];
    }
}
