<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WeeklyOrdersExport implements FromCollection, WithMultipleSheets
{
    protected array $weekdays;

    protected Collection $lunches;

    public function __construct(array $weekdays, Collection $lunches)
    {
        $this->weekdays = $weekdays;
        $this->lunches = $lunches;
    }

    public function collection(): Collection
    {
        return collect([$this->weekdays]);
    }

    public function sheets(): array
    {
        $sheets = [];

        $weekdayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($this->weekdays as $index => $weekdayDate) {
            $weekdayName = $weekdayNames[$index];
            $sheets[$weekdayDate] = new WeeklyOrdersPerDaysSheet($weekdayDate, $weekdayName, $this->lunches);
        }

        return $sheets;
    }
}
