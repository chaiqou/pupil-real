<?php

namespace App\Http\Controllers\School\Api\Lunch;

use App\Http\Controllers\Controller;
use App\Http\Requests\LunchRequest;
use App\Http\Resources\LunchResource;
use App\Models\Lunch;
use App\Models\Merchant;
use App\Models\PeriodicLunch;
use App\Models\Terminal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LunchController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $lunches = Lunch::where('merchant_id', auth()->user()->school_id)->paginate(9);

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

    public function retrieveLunch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'public_key' => 'required',
            'signature' => 'required|size:128',
            'card_data' => 'required',
            'lunch_date' => 'required|date_format:Y.m.d'
        ]);
        Log::info($request->all());
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }
        $validated = $validator->validated();

        $terminal = Terminal::where('public_key', $validated['public_key'])->first();
        if (!$terminal) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }
        $message = $validated['lunch_date'] . $validated['card_data'];
        $validSignature = strtoupper(hash('sha512', $message . $terminal->private_key));

        if ($validSignature !== strtoupper($validated['signature'])) {
            return response()->json(['error' => 'Invalid signature.'], 401);
        } else {
            $lunches = PeriodicLunch::where('card_data', $validated['card_data'])->get();
            if ($lunches) {
                Log::info('Lunches found');
                foreach ($lunches as $lunch) {
                    Log::info('Checking lunch');
                    //Convert the lunch start and end date to "YYYY.MM.DD" format
                    $lunchStartDate = date('Y.m.d', strtotime($lunch->start_date));
                    $lunchEndDate = date('Y.m.d', strtotime($lunch->end_date));
                    Log::info($lunchStartDate);
                    Log::info($lunchEndDate);
                    //Check if the date is in the active range
                    if ($lunchStartDate <= $request->lunch_date && $lunchEndDate >= $request->lunch_date) {
                        $claims = json_decode($lunch->claims, true);
                        $checkDate = Carbon::createFromFormat('Y.m.d', $validated['lunch_date'])->format('Y-m-d');
                        foreach ($claims as $key => $claim) {
                            if($key == $checkDate){
                                return response()->json(['lunch' => $claim], 200);
                            }
                        }
                    }
                }
                // If there's no claim for the date, return the No lunch found for the user error
                return response()->json(['error' => 'No lunch found for the user for the specified date.'], 404);
            } else {
                return response()->json(['error' => 'No lunches found for the user.'], 404);
            }
        }
    }
}
