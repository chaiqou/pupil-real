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

    protected Collection $lunches;

    public function __construct(string $weekdayDate, string $weekdayName, Collection $lunches)
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

            $lunchOrderCount = $lunch->periodicLunches()
                ->where('lunch_id', $lunch->id)
                ->count();

            // We are calculating for each sheet specific title like "2023-04-13 - Monday"
            $lunchDateTitle = "{$this->weekdayDate} - {$this->weekdayName}";

            // Add lunch data for the current day to the lunchData array
            $lunchData[$this->weekdayDate] = [
                'Lunch Date' => $lunchDateTitle,
                'Lunch Orders' => $lunchOrderCount ?: 'Not Ordered yet',
                'Lunch Name' => $lunch->title,
            ];

            if (isset($lunch['menus'])) {
                foreach ($lunch['menus'] as $lunchMenu) {
                    $menus = json_decode($lunchMenu->menus, true);

                    foreach ($menus as $menuDate => $menuArrays) {
                        foreach ($menuArrays as $menu) {
                            if ($this->weekdayDate === $menuDate) {
                                //
                                if (is_array($menu['menus'])) {
                                    foreach ($menu['menus'] as $menuName) {
                                        if ($menuName) {
                                            $menuData[] = $this->createMenuData($lunch->title, $menuName['menus'], $menuName['menu_count'], $menu['name'], $lunchOrderCount);

                                        }
                                    }
                                } else {
                                    $menuData[] = $this->createMenuData($lunch->title, $menu['menus'], $menu['menu_count'], $menu['name'], $lunchOrderCount);

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

    private function createMenuData($lunchTitle, $menuName, $menuCount, $menuType, $lunchOrderCount): array
    {
        return [
            'Lunch Date' => '',
            'Lunch Orders' => '',
            'Lunch Name' => $lunchTitle,
            'Menu Name' => $menuName,
            'Menu Count' => $menuCount ?: 'Not Ordered yet',
            'Menu Type' => $menuType ?: 'Without Type',
            "Menu's remainder" => $lunchOrderCount - $menuCount ?: 'All users have already made their choices.',
        ];
    }

    public function headings(): array
    {
        return [
            'Lunch Date',
            'Lunch Orders',
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
