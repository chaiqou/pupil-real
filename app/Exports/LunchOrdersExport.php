<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LunchOrdersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    private $lunches;

    private $totalOrders;

    public function __construct($lunches, $totalOrders)
    {
        $this->lunches = $lunches;
        $this->totalOrders = $totalOrders;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->lunches as $lunch) {
            $menuRows = []; // define an empty array to hold the rows for the current lunch
            if (isset($lunch['menus'])) {
                foreach ($lunch['menus'] as $lunchMenu) {
                    $lunchMenusDecoded = json_decode($lunchMenu->menus, true);

                    foreach ($lunchMenusDecoded as $menuDate => $menuItems) {
                        foreach ($menuItems as $menuItem) {
                            $menuRows[] = [
                                'Menu Name' => $menuItem['menus'],
                                'Menu Count' => $menuItem['menu_count'],
                                'Menu Date' => $menuDate,
                            ];
                        }
                    }
                }
            }

            $totalOrders = isset($this->totalOrders[$lunch->id]) ? $this->totalOrders[$lunch->id] : 0;

            $data[] = [
                'Lunch Name' => $lunch->title,
                'Total Orders' => $totalOrders ?: 'Not Ordered yet',
            ];

            if (! empty($menuRows)) { // only add the rows if there are any
                $data[] = []; // add an empty row for spacing

                $headers = [
                    'Menu Name',
                    'Menu Count',
                    'Menu Date',
                ];
                $data[] = $headers; // add the headers for the menu rows

                foreach ($menuRows as $menuRow) {
                    $data[] = $menuRow; // add each menu row
                }
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Lunch Name',
            'Total Orders',
        ];
    }
}
