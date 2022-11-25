<?php

namespace App\Http\Controllers\School\Api\Lunch;

use App\Http\Controllers\Controller;
use App\Http\Requests\LunchRequest;
use App\Http\Resources\LunchResource;
use App\Models\Lunch;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\Concerns\Interaction;

class LunchController extends Controller
{
    public function store(LunchRequest $request)
    {
        $validate = $request->validated();
        $activeRange = collect($validate['active_range']);
        $extras= collect($validate['extras']);
        $holds = collect($validate['holds']);
        $tags = collect($validate['tags']);

           $onlyMatchedDays = $activeRange->filter(function ($date) use ($tags) {
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date);

            return $tags->search($carbonDate->dayName);
        });

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
}
