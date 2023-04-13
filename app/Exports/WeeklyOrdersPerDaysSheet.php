<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WeeklyOrdersPerDaysSheet implements FromCollection, WithTitle, WithStyles
{
    protected $weekdayDate;

    protected $weekdayName;

    protected $lunches;

    public function __construct($weekdayDate, $weekdayName, $lunches)
    {
        $this->weekdayDate = $weekdayDate;
        $this->weekdayName = $weekdayName;
        $this->lunches = $lunches;
    }

    public function collection()
    {
        // We are calculating for each sheet specific title like "2023-04-13 - Monday"

        $title = collect($this->weekdayDate)->map(function ($weekdayDate) {
            return "{$weekdayDate} - {$this->weekdayName}";
        });

        // Total order count for each day

        $totalCountPerDay = 0;

        foreach ($this->lunches as $lunch) {
            // Format date like "start_date" and "end_date" format in DB for periodic lunches
            $formattedDate = date('Y-m-d H:i:s', strtotime($this->weekdayDate));

            // Based on Lunches fetch specific periodic lunches which have start and end date based formatted date
            $periodicLunches = $lunch->periodicLunches()
                                     ->where('start_date', '<=', $formattedDate)
                                     ->where('end_date', '>=', $formattedDate)
                                     ->get();

            // Increment the totalCountPerDay with the number of periodic lunches retrieved for each lunch
            $totalCountPerDay += $periodicLunches->count();
        }

        return collect([['totalCountPerDay' => $totalCountPerDay], $title]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
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

    public function title(): string
    {
        return "{$this->weekdayName} | {$this->weekdayDate}";
    }
}
