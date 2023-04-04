<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Exports\LunchOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\LunchMenu;
use App\Services\ExcelService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MenuExportController extends Controller
{
    protected $excelService;

    public function __construct(ExcelService $excelService)
    {
        $this->excelService = $excelService;
    }

    public function exportMenu(Request $request)
    {
        $dayAndWeekJson = $request->query('dayAndWeek');
        $dayAndWeek = json_decode($dayAndWeekJson);

        $lunches = $this->excelService->findLunchesForExcelFile($dayAndWeek[0]->week);

        // convert array to collection
        $lunchesCollection = collect($lunches);
        $menus = LunchMenu::whereIn('lunch_id', $lunchesCollection->pluck('id'))->get();

        $totalOrders = [];
        foreach ($lunches as $lunch) {
            $totalOrders[$lunch->id] = $lunch->periodicLunches->count();
        }

        return Excel::download(new LunchOrdersExport($lunches, $totalOrders), 'lunches_total.xlsx');
    }
}
