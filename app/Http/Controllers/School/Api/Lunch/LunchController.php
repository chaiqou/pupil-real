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
        $weekdays = collect($validate['weekdays']);
        $holds = collect($validate['holds']);
        $extras = collect($validate['extras']);

        //  selected days that fall on the active range
        $onlyMatchedDays = $activeRange->map(function ($date) use ($weekdays) {
            if ($weekdays->contains(Carbon::parse($date)->dayName)) {
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

        // if extras is not empty , then we need to add the days that fall on the extras
        if ($extras->count() > 0) {
            $extras->map(function ($extra, $key) use ($onlyMatchedDays) {
                if (! $onlyMatchedDays->contains($extra)) {
                    $onlyMatchedDays->push($extra);
                }
            });
        }

        $sortedMatchedDays = $onlyMatchedDays->sort();

        $lunch = Lunch::create([
            'merchant_id' => auth()->user()->id,
            'title' => $validate['title'],
            'description' => $validate['description'],
            'active_range' => $validate['active_range'],
            'period_length' => $validate['period_length'],
            'claimables' => $validate['claimables'],
            'holds' => $validate['holds'] ?? null,
            'extras' => $validate['extras'] ?? null,
            'weekdays' => $validate['weekdays'],
            'available_days' => $sortedMatchedDays->values()->all(),
            'price_day' => $validate['price_day'],
            'price_period' => $validate['price_period'],
        ]);

        return new LunchResource($lunch);
    }
}
