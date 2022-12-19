<?php

namespace App\Http\Controllers\School\Api\Lunch;

use Carbon\Carbon;
use App\Models\Lunch;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LunchRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\LunchResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LunchController extends Controller
{

    public function index (): AnonymousResourceCollection
    {
        $lunches = Lunch::where('merchant_id', auth()->user()->school_id)->paginate(9);

        return LunchResource::collection($lunches);
    }

    public function calculateFirstAvailableDate($bufferTime , $availableDays, $periodLength)
    {
        $currentDate = Carbon::now();


        $firstAvailableDate = $currentDate->addHours($bufferTime)->addDay();



        // remove days which before $firstAvailableDate
        foreach ($availableDays as $key => $date) {
            $date = Carbon::parse($date);
            if ($date->lt($firstAvailableDate)) {
                unset($availableDays[$key]);
            }
        }


        $availableDays = array_slice($availableDays, 0, count($availableDays) - $periodLength);


        return $availableDays;
    }


    public function store(LunchRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $merchantId = Merchant::where('school_id', auth()->user()->school_id)->first();

      $availableOrderDays = $this->calculateFirstAvailableDate($validate['buffer_time'],$validate['available_days'],$validate['period_length']);

      Lunch::create([
            'merchant_id' => $merchantId->id,
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
            'order_days' => $availableOrderDays ?? null,
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
