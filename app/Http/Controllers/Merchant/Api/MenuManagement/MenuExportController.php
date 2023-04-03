<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Exports\LunchOrdersExport;
use App\Http\Controllers\Controller;
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

        $appropiateLunches = $this->excelService->findLunchesForExcelFile($dayAndWeek[0]->week);

        // Total count
        foreach ($appropiateLunches as $lunch) {
            $totalOrders = $lunch->periodicLunches->count();
        }

        return Excel::download(new LunchOrdersExport, 'lunches_total.xlsx');
    }
}
