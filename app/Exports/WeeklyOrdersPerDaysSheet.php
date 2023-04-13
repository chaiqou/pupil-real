<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WeeklyOrdersPerDaysSheet implements FromCollection, WithTitle, WithStyles, ShouldAutoSize, WithHeadings
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

        $lunchDateTitle = collect($this->weekdayDate)->map(function ($weekdayDate) {
            return "{$weekdayDate} - {$this->weekdayName}";
        })->implode(', '); // Implode the array into a string;

        // Total order count for each day

        $totalCountPerDay = 0;

        // Total lunch information
        $data = [];

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

            // Keys should match headings values
            $data[] = [
                'Lunch Date' => $lunchDateTitle,
                'Total Orders' => $totalCountPerDay ?: 'Not Ordered yet',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Lunch Date',
            'Total Orders',
        ];
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
