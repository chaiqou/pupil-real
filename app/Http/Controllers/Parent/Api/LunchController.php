<?php

namespace App\Http\Controllers\Parent\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LunchController extends Controller
{
    public function calculateFirstAvailableDate()
    {
        $currentDate = Carbon::now();

        // hard coded buffer time for example
        $bufferTime = 12;

        // hard coded available dates

        $availableDates = [
            '2022-01-01',
            '2022-01-02',
            '2022-01-03',
            '2022-01-04',
        ];

        // hard coded period length
        $periodLength = 7;

        $firstAvailableDate = $currentDate->addHours($bufferTime)->addDay();

        // remove days which before $firstAvailableDate
        foreach ($availableDates as $key => $date) {
            $date = Carbon::parse($date);
            if ($date->lt($firstAvailableDate)) {
                unset($availableDates[$key]);
            }
        }

        $availableDates = array_slice($availableDates, 0, count($availableDates) - $periodLength);


         dump($availableDates);
    }
}
