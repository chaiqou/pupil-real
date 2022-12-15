<?php

namespace App\Http\Controllers\School\Api\Lunch;

use Carbon\Carbon;
use App\Models\Lunch;
use App\Models\School;
use App\Models\Merchant;
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
