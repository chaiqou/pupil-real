<?php

namespace App\Http\Controllers\School\Api\Lunch;

use App\Http\Controllers\Controller;
use App\Http\Requests\LunchRequest;
use App\Http\Resources\LunchResource;
use App\Models\Lunch;
use Carbon\Carbon;

class LunchController extends Controller
{
    public function store(LunchRequest $request)
    {
        $validate = $request->validated();
        $activeRange = collect($validate['active_range']);
        $tags = collect($validate['tags']);
        $holds = collect($validate['holds']);
        $extras = collect($validate['extras']);

        //  selected days that fall on the active range
        $onlyMatchedDays = $activeRange->map(function ($date) use ($tags) {
            if ($tags->contains(Carbon::parse($date)->shortDayName)) {
                return $date;
            }
        })->reject(function ($date) {
            return empty($date);
        });

        // if holds is not empty, then we need to remove the days that fall on the holds
        if ($holds->count() > 0) {
            $holds->map(function ($hold, $key) use ($onlyMatchedDays) {
                if ($onlyMatchedDays->contains($hold)) {
                    $searchAppropiateHoldId = $onlyMatchedDays->search($hold);
                    $removedHolds = $onlyMatchedDays->forget($searchAppropiateHoldId);
                    $onlyMatchedDays = $removedHolds;
                }
            });
        }

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
            'available_days' => $onlyMatchedDays->toArray(),
            'price_day' => $validate['price_day'],
            'price_period' => $validate['price_period'],
        ]);

        return new LunchResource($lunch);
    }
}
