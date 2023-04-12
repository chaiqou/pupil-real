<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WeeklyOrderSheetsExport implements FromCollection, WithMultipleSheets
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

        foreach ($this->weekdays as $weekday) {
            $sheets[$weekday] = new WeeklyOrderExport($weekday);
        }

        return $sheets;
    }
}
