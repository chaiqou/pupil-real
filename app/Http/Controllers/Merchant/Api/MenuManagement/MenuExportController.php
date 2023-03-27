<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuExportController extends Controller
{
    public function exportMenu(Request $request)
    {
        dd($request->all());
    }
}
