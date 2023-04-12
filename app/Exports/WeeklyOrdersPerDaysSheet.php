<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WeeklyOrdersPerDaysSheet implements FromCollection, WithTitle, WithStyles, WithCustomStartCell
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
            return "{$weekdayDate} - {$this->weekdayName}";
        });

        // Wrap merged row in a collection
        return  collect([$meregWeekDates]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => [
                'font' => [
                    'bold' => true, // Set the font to bold
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT, // Set horizontal alignment to center
                    'vertical' => Alignment::VERTICAL_CENTER, // Set vertical alignment to center
                ],
            ],

        ];
    }

    public function startCell(): string
    {
        return 'K2';
    }

    public function title(): string
    {
        return "{$this->weekdayName} | {$this->weekdayDate}";
    }
}
