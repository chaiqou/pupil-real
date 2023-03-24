<?php

namespace App\Services;

use Carbon\Carbon;

class CalendarService
{
    public function groupAvailableDaysByWeek($lunches)
    {
        // Group the available days of each lunch by the week they belong to, starting from the first week of January.
        $firstDayOfYear = Carbon::parse('first day of January');
        $allWeeks = [];

        foreach ($lunches as $lunch) {
            $weeks = collect($lunch['available_days'])->map(function ($day) use ($firstDayOfYear) {
                $weekNumber = Carbon::parse($day)->diffInWeeks($firstDayOfYear) + 1;

                return [
                    'date' => $day,
                    'week' => $weekNumber,
                ];
            })->sortBy('date')->groupBy('week')->toArray();

            $allWeeks[] = $weeks;
        }

        return $allWeeks;
    }
}
