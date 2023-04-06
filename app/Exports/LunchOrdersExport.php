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
            $menusArray = []; // define an empty array before the inner loop
            // loop over the lunch menus
            foreach ($lunch['menus'] as $lunchMenu) {
                $lunchMenusDecoded = json_decode($lunchMenu->menus, true);
                $menusArray[] = $lunchMenusDecoded; // add the decoded menus to the array
            }

            $totalOrders = isset($this->totalOrders[$lunch->id]) ? $this->totalOrders[$lunch->id] : 0;

            $data[] = [
                'Lunch ID' => $lunch->id,
                'Lunch Name' => $lunch->title,
                'Total Orders' => $totalOrders ?: 'Not Ordered yet',
                'Menus' => $menusArray, // assign the array to the 'Menus' key
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Lunch ID',
            'Lunch Name',
            'Total Orders',
            'Menus',
        ];
    }
}
