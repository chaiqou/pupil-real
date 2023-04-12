<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class WeeklyOrderExport implements FromCollection, WithTitle
{
    protected $weekday;

    public function __construct($weekday)
    {
        $this->weekday = $weekday;
    }

    public function collection()
    {
        $weekdaysCollection = collect($this->weekday);
        $mergedOneRow = $weekdaysCollection->reduce(function ($carry, $weekday) {
            // Add each weekday as an array with 3 columns
            return array_merge($carry, [$weekday, null, null]);
        }, []);

        // Wrap merged row in a collection
        return collect([$mergedOneRow]);
    }

    public function title(): string
    {
        return $this->weekday;
    }
}
