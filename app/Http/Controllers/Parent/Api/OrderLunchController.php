<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderLunchController extends Controller
{
    public function index(Request $request)
    {
        dump($request->all());

        return response()->json(['success' => 'success']);
    }
}
