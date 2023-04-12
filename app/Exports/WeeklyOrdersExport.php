<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TestExport implements FromCollection
{
    private $lunches;

    private $totalOrders;

    private $weekdays;

    public function __construct($lunches, $totalOrders, $weekdays)
    {
        $this->lunches = $lunches;
        $this->totalOrders = $totalOrders;
        $this->weekdays = $weekdays;
    }

    public function collection()
    {
        $weekdaysCollection = collect($this->weekdays);

        $mappedWeekdays = $weekdaysCollection->map(function ($weekday) {
            return [$weekday];
        });

        return $mappedWeekdays;
    }
}
