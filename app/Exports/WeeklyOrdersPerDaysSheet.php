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
        })->implode(', '); // Implode the array into a string

        // Lunch information
        $lunchData = [];

        // Menu information
        $menuData = [];

        foreach ($this->lunches as $lunch) {
            // Format date like "start_date" and "end_date" format in DB for periodic lunches
            $formattedDate = date('Y-m-d H:i:s', strtotime($this->weekdayDate));

            // Based on Lunches fetch specific periodic lunches which have start and end date based formatted date
            $periodicLunches = $lunch->periodicLunches()
                ->where('start_date', '<=', $formattedDate)
                ->where('end_date', '>=', $formattedDate)
                ->get();

            // Total order count for each day
            $totalCountPerDay = $periodicLunches->count();

            // Keys should match headings values
            $lunchData[] = [
                'Lunch Date' => $lunchDateTitle,
                'Lunch Name' => $lunch->title,
                'Total Orders' => $totalCountPerDay ?: 'Not Ordered yet',
            ];

            $menuRows = []; // define an empty array to hold the rows for the menus
            if (isset($lunch['menus'])) {
                foreach ($lunch['menus'] as $lunchMenu) {
                    $lunchMenusDecoded = json_decode($lunchMenu->menus, true);

                    foreach ($lunchMenusDecoded as $menuDate => $menuItems) {
                        foreach ($menuItems as $menuItem) {
                            if ($this->weekdayDate == $menuDate) { // Add the menu row only if $this->weekdayDate matches $menuDate
                                $menuRows[] = [
                                    'Menu Name' => $menuItem['menus'],
                                    'Menu Count' => $menuItem['menu_count'],
                                ];
                            }
                        }
                    }
                }
            }

            if (! empty($menuRows)) { // only add the rows if there are any
                $menuData[] = []; // add an empty row for spacing

                $headers = [
                    'Menu Name',
                    'Menu Count',

                ];
                $menuData[] = $headers; // add the headers for the menu rows

                foreach ($menuRows as $menuRow) {
                    $menuData[] = $menuRow; // add each menu row
                }
            }
        }

        // Combine the lunch and menu data arrays
        $data = array_merge($lunchData, $menuData);

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Lunch Date',
            'Lunch Name',
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
