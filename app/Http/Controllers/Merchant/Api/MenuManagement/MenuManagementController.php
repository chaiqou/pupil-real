<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuManagementController extends Controller
{
    public function createMenu(Request $request)
    {
        dd($request->all());
    }
}
