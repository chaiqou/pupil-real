<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WeeklyOrdersPerDaysSheet implements FromCollection, WithTitle, WithStyles, ShouldAutoSize, WithHeadings
{
    protected string $weekdayDate;

    protected string $weekdayName;

    protected array $lunches;

    public function __construct(string $weekdayDate, string $weekdayName, array $lunches)
    {
        $this->weekdayDate = $weekdayDate;
        $this->weekdayName = $weekdayName;
        $this->lunches = $lunches;
    }

    public function collection(): Collection
    {
        // Lunch information
        $lunchData = [];

        // Menu information
        $menuData = [];

        foreach ($this->lunches as $lunch) {
            // Format date like "start_date" and "end_date" format in DB for periodic lunches
            $formattedDate = date('Y-m-d H:i:s', strtotime($this->weekdayDate));

            // Based on Lunches fetch specific periodic lunches which have start and end date based formatted date
            $periodicLunches = $lunch->periodicLunches()->
                where('lunch_id', $lunch->id)
                ->get();

            // Total order count for each day
            $totalCountPerDay = $periodicLunches->count();

            // We are calculating for each sheet specific title like "2023-04-13 - Monday"
            $lunchDateTitle = "{$this->weekdayDate} - {$this->weekdayName}";

            // Add lunch data for the current day to the lunchData array
            $lunchData[$this->weekdayDate] = [
                'Lunch Date' => $lunchDateTitle,
                'Total Orders' => $totalCountPerDay ?: 'Not Ordered yet',
                'Lunch Name' => $lunch->title,
            ];

            if (isset($lunch['menus'])) {
                foreach ($lunch['menus'] as $lunchMenu) {
                    $lunchMenusDecoded = json_decode($lunchMenu->menus, true);

                    foreach ($lunchMenusDecoded as $menuDate => $menuItems) {
                        foreach ($menuItems as $menuItem) {
                            if ($this->weekdayDate == $menuDate) { // Add the menu row only if $this->weekdayDate matches $menuDate
                                if (is_array($menuItem['menus'])) { // Check if 'Menu Name' value is an array
                                    foreach ($menuItem['menus'] as $menuName) {
                                        if ($menuName) {
                                            $menuData[] = [
                                                'Lunch Date' => '',
                                                'Total Orders' => '',
                                                'Lunch Name' => $lunch->title,
                                                'Menu Name' => $menuName['menus'], // Loop over 'Menu Name' array and generate separate rows
                                                'Menu Count' => $menuName['menu_count'] ?: 'Not Ordered yet', // Use 'Menu Count' value from original array
                                                'Menu Type' => $menuItem['name'] ?: 'Without Type',
                                                "Menu's remainder" => $totalCountPerDay - $menuName['menu_count'] ?: 'All users have already made their choices.',
                                            ];
                                        }
                                    }
                                } else {
                                    $menuData[] = [
                                        'Lunch Date' => '',
                                        'Total Orders' => '',
                                        'Lunch Name' => $lunch->title,
                                        'Menu Name' => $menuItem['menus'],
                                        'Menu Count' => $menuItem['menu_count'] ?: 'Not Ordered yet',
                                        'Menu Type' => $menuItem['name'] ?: 'Without Type',
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        $data = array_merge($lunchData, $menuData);

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Lunch Date',
            'Total Orders',
            'Lunch Name',
            'Menu Name',
            'Menu Count',
            'Menu Type',
            "Menu's remainder",
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

        ];
    }

    public function title(): string
    {
        return "{$this->weekdayName} | {$this->weekdayDate}";
    }
}
