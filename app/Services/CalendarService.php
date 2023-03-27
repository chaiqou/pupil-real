<?php

namespace App\Services;

use Carbon\Carbon;

class CalendarService
{
    public function groupAvailableDaysByWeek($lunches): array
    {
        // Group the available days of each lunch by the week they belong to, starting from the first week of January.

        // Find first day of year for calculating
        $firstDayOfYear = Carbon::parse('first day of January')->startOfWeek(Carbon::MONDAY);

        $allWeeks = [];

        // Loop over the Lunches i want loop over the all lunch
        foreach ($lunches as $lunch) {
            $weeks = collect($lunch['available_days'])->map(function ($day) use ($firstDayOfYear) {
                // Find correct week number from January (if now is 21 january week number will be 3)
                $weekNumber = Carbon::parse($day)->diffInWeeks($firstDayOfYear);

                return [
                    'date' => $day,
                    'week' => $weekNumber,
                ];
            })->sortBy('date')->groupBy('week')->toArray();

            // Save all weeks in array
            $allWeeks[] = $weeks;
        }

        return $allWeeks;
    }
}
