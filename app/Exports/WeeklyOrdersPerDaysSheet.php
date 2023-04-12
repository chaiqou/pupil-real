<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class WeeklyOrdersPerDaysSheet implements FromCollection, WithTitle
{
    protected $weekdayDate;

    protected $weekdayName;

    public function __construct($weekdayDate, $weekdayName)
    {
        $this->weekdayDate = $weekdayDate;
        $this->weekdayName = $weekdayName;
    }

    public function collection()
    {
        $weekdaysCollection = collect($this->weekdayDate);
        $mergedOneRow = $weekdaysCollection->reduce(function ($carry, $weekdayDate) {
            // Add each weekday as an array with 3 columns
            return array_merge($carry, [$weekdayDate, null, null]);
        }, []);

        // Wrap merged row in a collection
        return collect([$mergedOneRow]);
    }

    public function title(): string
    {
        return $this->weekdayName.' '.'|'.' '.$this->weekdayDate;
    }
}
