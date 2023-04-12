<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;


class WeeklyOrdersPerDaysSheet implements FromCollection, WithTitle
{
    protected $weekdayDate;

    protected $weekdayName;

    public function __construct($weekdayDate, $weekdayName)
    {
        $this->weekdayDate = $weekdayDate;
        $this->weekdayName = $weekdayName;
    }

    public function collection(): Collection
    {
        $meregWeekDates = collect($this->weekdayDate)->map(function ($weekdayDate) {
            return $weekdayDate;
        });

        // Wrap merged row in a collection
        return  collect([$meregWeekDates]);
    }

    public function title(): string
    {
        return "{$this->weekdayName} | {$this->weekdayDate}";
    }
}
