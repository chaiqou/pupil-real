<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LunchRequest;
use App\Http\Resources\LunchResource;
use App\Models\Lunch;
use Illuminate\Http\Request;

class LunchController extends Controller
{
    public function index()
    {
    }

    public function store(LunchRequest $request)
    {
        $validate = $request->validated();

        $lunch = Lunch::create([
            'merchant_id' => auth()->user()->id,
            'title' => $validate['title'],
            'description' => $validate['description'],
            'active_range' => $validate['active_range'],
            'period_length' => $validate['period_length'],
            'claimables' => $validate['claimables'],
            'holds' => $validate['holds'] ?? null,
            'extras' => $validate['extras'] ?? null,
            'tags' => $validate['tags'],
            'available_days' => 3,
            'price_day' => $validate['price_day'],
            'price_period' => $validate['price_period'],
        ]);

        return new LunchResource($lunch);
    }

    public function show(Lunch $lunch)
    {
    }

    public function update(Request $request, Lunch $lunch)
    {
    }

    public function destroy(Lunch $lunch)
    {
    }
}