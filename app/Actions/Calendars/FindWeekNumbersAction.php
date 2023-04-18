<?php

namespace App\Actions\Calendars;

use Carbon\Carbon;

class FindWeekNumbersAction
{
    public static function execute($lunches): array
    {

         // Group the available days of each lunch by the week they belong to, starting from the first week of January.

        $firstDayOfYear = Carbon::parse('first day of January')->startOfWeek(Carbon::MONDAY);

        $weeksArray = [];

        foreach ($lunches as $lunch) {
            $weeks = collect($lunch['available_days'])->map(function ($day) use ($firstDayOfYear) {
                // Find correct week number from January (if now is 21 january week number will be 3)
                $weekNumber = Carbon::parse($day)->diffInWeeks($firstDayOfYear);

                return [
                    'date' => $day,
                    'week' => $weekNumber,
                ];
            })->sortBy('date')->groupBy('week')->toArray();

            $weeksArray[] = $weeks;
        }

        return $weeksArray;
    }
}
