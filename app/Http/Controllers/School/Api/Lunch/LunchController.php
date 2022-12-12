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
        $bufferTime = collect($validate['time_picker']);
        $periodLength = (int) $validate['period_length'];

        $currentTime = Carbon::now();

        $firstDate = $currentTime->addHours($periodLength)->addMinutes($bufferTime->first());


        if ($currentTime < $firstDate) {

            dump('enough buffer time left');
        } else {

            dump('not enough buffer time left');
        }


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
            'time_picker' => $validate['time_picker'],
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
