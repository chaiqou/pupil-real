<?php

namespace App\Http\Controllers\School\Api\Lunch;

use Carbon\Carbon;
use App\Models\Lunch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LunchRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\LunchResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LunchController extends Controller
{

    public function index (): AnonymousResourceCollection
    {
        $lunches = Lunch::where('merchant_id', auth()->user()->id)->paginate(9);


        return LunchResource::collection($lunches);
    }


    public function store(LunchRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $bufferTime = (int) $validate['buffer_time'];
        $periodLength = (int) $validate['period_length'];
        $currentTime = Carbon::now();
        $periodEnd = $currentTime->addHours($periodLength);


        if ($periodEnd->gt($currentTime->endOfDay())) {
            // If the current time is before noon, the first available date is tomorrow
            if ($currentTime->lt($currentTime->noon())) {
                $firstAvailableDate = $currentTime->tomorrow();
            } else {
                // Otherwise, the first available date is the day after tomorrow
                $firstAvailableDate = $currentTime->tomorrow()->tomorrow();
            }
            $bufferTime = $firstAvailableDate->diffInHours($currentTime);
        } else {
            $firstAvailableDate = $currentTime;
            $bufferTime = 0;
        }

        dump($firstAvailableDate->toDateTimeString());


       Lunch::create([
            'merchant_id' => auth()->user()->id,
            'title' => $validate['title'],
            'description' => $validate['description'],
            'active_range' => $validate['active_range'],
            'period_length' => $validate['period_length'],
            'claimables' => $validate['claimables'],
            'holds' => $validate['holds'] ?? null,
            'extras' => $validate['extras'] ?? null,
            'weekdays' => $validate['weekdays'],
            'available_days' => $validate['available_days'],
            'price_day' => $validate['price_day'],
            'price_period' => $validate['price_period'],
            'buffer_time' => $validate['buffer_time'],
        ]);

       return response()->json(['success' => 'Lunch created successfully'], 201);
    }

    public function show(Lunch $lunch): LunchResource
    {
        return new LunchResource($lunch);
    }

    public function update(LunchRequest $request, Lunch $lunch)
{
    $validatedData = $request->validated();

    $lunch->update($validatedData);

    $lunches = Lunch::where('merchant_id', auth()->user()->id)->paginate(9);

    return LunchResource::collection($lunches);
}

}
