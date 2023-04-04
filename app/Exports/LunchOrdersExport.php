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
            $totalOrders = isset($this->totalOrders[$lunch->id]) ? $this->totalOrders[$lunch->id] : 0;

            $data[] = [
                'Lunch ID' => $lunch->id,
                'Lunch Name' => $lunch->title,
                'Total Orders' => $totalOrders ?: 'Not Ordered yet',
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
        ];
    }
}
