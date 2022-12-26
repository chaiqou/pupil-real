<?php

namespace App\Http\Controllers\School\Api\Lunch;

use App\Http\Controllers\Controller;
use App\Http\Requests\LunchRequest;
use App\Http\Requests\School\ClaimLunchRequest;
use App\Http\Requests\School\RetrieveLunchRequest;
use App\Http\Resources\LunchResource;
use App\Models\Lunch;
use App\Models\Merchant;
use App\Models\PeriodicLunch;
use App\Models\Student;
use App\Models\Terminal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function retrieveLunch(RetrieveLunchRequest $request)
    {
        $validated = $request->validated();


        if ($validated->fails()) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }

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
                foreach ($lunches as $lunch) {
                    //Convert the lunch start and end date to "YYYY.MM.DD" format
                    $lunchStartDate = date('Y.m.d', strtotime($lunch->start_date));
                    $lunchEndDate = date('Y.m.d', strtotime($lunch->end_date));

                    //Check if the date is in the active range
                    if ($lunchStartDate <= $request->lunch_date && $lunchEndDate >= $request->lunch_date) {
                        $claims = json_decode($lunch->claims, true);
                        $checkDate = Carbon::createFromFormat('Y.m.d', $validated['lunch_date'])->format('Y-m-d');
                        foreach ($claims as $key => $claim) {
                            if ($key == $checkDate) {
                                //Filter "claims" out of $lunch
                                //Get the student's data from the lunch student_id
                                $student = Student::where('id', $lunch->student_id)->first();
                                $lunch->student = $student->only(['id', 'first_name', 'last_name', 'middle_name']);
                                $originalPlan = Lunch::where('id', $lunch->lunch_id)->first();
                                $lunch->original_plan = $originalPlan->only(['id','title','description','period_length','weekdays','active_range','claimables','buffer_item','price_period','created_at','updated_at']);
                                return response()->json(['lunch' => $claim, 'lunch_meta' => $lunch->only(['id', 'student_id', 'card_data', 'transaction_id', 'merchant_id', 'lunch_id', 'lunch_id', 'start_date', 'end_date', 'created_at', 'updated_at', 'student', 'original_plan'])], 200);
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

    public function claimLunch(ClaimLunchRequest $request)
    {
        $validated = $request->validated();

        if ($validated->fails()) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }

        $terminal = Terminal::where('public_key', $validated['public_key'])->first();
        if (!$terminal) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }
        $message = $validated['lunch_date'] . $validated['lunch_id'] . $validated['claim_name'] . $validated['claim_date'];
        $validSignature = strtoupper(hash('sha512', $message . $terminal->private_key));

        if ($validSignature !== strtoupper($validated['signature'])) {
            return response()->json(['error' => 'Invalid signature.'], 401);
        } else {
            $lunch = PeriodicLunch::where('id', $validated['lunch_id'])->first();
            if($lunch->merchant_id != $terminal->merchant_id) {
                return response()->json(['error' => 'Invalid request.'], 400);
            }
            if ($lunch) {
                $claims = json_decode($lunch->claims, true);
                $checkDate = Carbon::createFromFormat('Y.m.d', $validated['lunch_date'])->format('Y-m-d');
                foreach ($claims as $claimsKey => $claim) {
                    if ($claimsKey == $checkDate) {
                        //Find the claim where the name = $validated['claim_name']
                        foreach ($claim as $claimKey => $claimable) {
                            if ($claimable['name'] == $validated['claim_name']) {
                                if ($claimable['claimed'] == false) {
                                    $claimable['claimed'] = true;
                                    $claimable['claimed_date'] = $validated['claim_date'];
                                    //Update the $claim with the new claimable
                                    $claim[$claimKey] = $claimable;
                                    //Update the $claims with the new claim
                                    $claims[$claimsKey] = $claim;
                                    $lunch->claims = json_encode($claims);
                                    $lunch->save();
                                    return response()->json(['message' => 'Lunch successfully claimed.'], 200);
                                } else {
                                    return response()->json(['error' => 'Lunch already claimed.'], 409);
                                }
                            }
                        }
                    }
                }
            } else {
                return response()->json(['error' => 'No lunch found for the specified ID.'], 404);
            }
        }
    }
}
