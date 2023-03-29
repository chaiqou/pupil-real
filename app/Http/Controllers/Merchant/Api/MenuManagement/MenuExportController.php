<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Http\Controllers\Controller;
use App\Services\ExcelService;
use Illuminate\Http\Request;

class MenuExportController extends Controller
{
    protected $excelService;

    public function __construct(ExcelService $excelService)
    {
        $this->excelService = $excelService;
    }

    public function exportMenu(Request $request)
    {
        $appropiateLunches = $this->excelService->findLunchesForExcelFile($request[0]['week']);
    }
}
