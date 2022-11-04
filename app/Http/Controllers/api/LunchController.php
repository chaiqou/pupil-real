<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LunchResource;
use App\Models\Lunch;
use Illuminate\Http\Request;

class LunchController extends Controller
{

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Lunch created successfully',
            'lunch' => new LunchResource($request->all())
        ], 201);
    }


    public function show(Lunch $lunch)
    {
        //
    }


    public function update(Request $request, Lunch $lunch)
    {
        //
    }


    public function destroy(Lunch $lunch)
    {
        //
    }
}
