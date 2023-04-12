<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class WeeklyOrdersExport implements FromCollection
{
    use Exportable;

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

        // Merge weekdays into a single row
        $mergedOneRow = $weekdaysCollection->reduce(function ($carry, $weekday) {
            return array_merge($carry, [$weekday]);
        }, []);

        // Wrap merged row in a collection
        return collect([$mergedOneRow]);
    }
}
