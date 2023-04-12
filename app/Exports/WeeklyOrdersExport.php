<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WeeklyOrdersExport implements FromCollection, WithMultipleSheets
{
    protected $weekdays;

    public function __construct($weekdays)
    {
        $this->weekdays = $weekdays;
    }

    public function collection()
    {
        return collect([$this->weekdays]);
    }

    public function sheets(): array
    {
        $sheets = [];

        $weekdayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($this->weekdays as $index => $weekdayDate) {
            $weekdayName = $weekdayNames[$index];
            $sheets[$weekdayDate] = new WeeklyOrdersPerDaysSheet($weekdayDate, $weekdayName);
        }

        return $sheets;
    }
}
