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

        $this->calculateFirstAvailableDate();



        return LunchResource::collection($lunches);
    }

    public function calculateFirstAvailableDate()
    {
        $currentDate = Carbon::now();

        // hard coded buffer time for example
        $bufferTime = 72;

        // hard coded available dates

        $availableDates = [
            '2022-12-01',
            '2022-12-02',
            '2022-12-03',
            '2022-12-04',
            '2022-12-20',
            '2022-12-21',
            '2022-12-22',
            '2022-12-23',
            '2022-12-24',
            '2022-12-25',
            '2022-12-26',
            '2022-12-27',
            '2022-12-28',
            '2022-12-29',
            '2022-12-30',
 ];

        // hard coded period length
        $periodLength = 5;

        $firstAvailableDate = $currentDate->addHours($bufferTime)->addDay();

        dump($firstAvailableDate->toDateString());

        // remove days which before $firstAvailableDate
        foreach ($availableDates as $key => $date) {
            $date = Carbon::parse($date);
            if ($date->lt($firstAvailableDate)) {
                unset($availableDates[$key]);
            }
        }

        dump($availableDates);
        dump(count($availableDates) - $periodLength);

        $availableDates = array_slice($availableDates, 0, count($availableDates) - $periodLength);

        dump($availableDates);
        // return $availableDates;
    }


    public function store(LunchRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $merchantId = Merchant::where('school_id', auth()->user()->school_id)->first();

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
