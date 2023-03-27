<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuExportController extends Controller
{
    public function exportMenu(Request $request)
    {
        $firstDay = Carbon::parse($request[0]['date'])->startOfDay();
        $lastDay = Carbon::parse($request[count($request->all()) - 1]['date'])->endOfDay();
    }
}
