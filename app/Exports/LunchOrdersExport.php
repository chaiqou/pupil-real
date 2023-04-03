<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LunchOrdersExport implements FromView, ShouldAutoSize
{
    private $lunches;

    private $totalOrders;

    public function __construct($lunches, $totalOrders)
    {
        $this->lunches = $lunches;
        $this->totalOrders = $totalOrders;
    }

    public function view(): View
    {
        return view('lunches-excel', ['lunches' => $this->lunches, 'totalOrders' => $this->totalOrders]);
    }
}
