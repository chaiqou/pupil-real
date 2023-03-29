<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\MenuExportRequest;
use App\Services\ExcelService;

class MenuExportController extends Controller
{
    protected $excelService;

    public function __construct(ExcelService $excelService)
    {
        $this->excelService = $excelService;
    }

    public function exportMenu(MenuExportRequest $request)
    {
        $validated = $request->validated();
        $appropiateLunches = $this->excelService->findLunchesForExcelFile($validated['dayAndWeek'][0]['week']);
    }
}
