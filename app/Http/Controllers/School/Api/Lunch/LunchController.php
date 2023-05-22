<?php

namespace App\Http\Controllers\School\Api\Lunch;

use App\Actions\Calendars\FindWeekNumbersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\School\ClaimLunchRequest;
use App\Http\Requests\School\RetrieveLunchRequest;
use App\Http\Requests\School\StoreLunchRequest;
use App\Http\Requests\School\StudentListRequest;
use App\Http\Resources\LunchResource;
use App\Models\Lunch;
use App\Models\Merchant;
use App\Models\PeriodicLunch;
use App\Models\School;
use App\Models\Student;
use App\Models\Terminal;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LunchController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('school')) {
            $merchant = Merchant::where('user_id', auth()->user()->id)->first();
            $lunches = Lunch::where('merchant_id', $merchant->id)->paginate(9);
        }
        if (auth()->user()->hasRole('parent')) {
            $lunches = Lunch::where('school_id', auth()->user()->school_id)->orderByDesc('created_at')->paginate(9);
        }

        $weekNumbers = FindWeekNumbersAction::execute($lunches);
        $firstWeekOfCurrentMonth = Carbon::now()->startOfMonth()->weekOfYear;

        return response()->json(['lunches' => $lunches, 'weeks' => $weekNumbers, 'first_week' => $firstWeekOfCurrentMonth]);
    }

    public function store(StoreLunchRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $merchant = Merchant::where('user_id', auth()->user()->id)->first();

        Lunch::create([
            'merchant_id' => $merchant->id,
            'school_id' => $merchant->school_id,
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
            'vat' => $validate['vat'],
        ]);

        return response()->json(['success' => 'Lunch created successfully'], 201);
    }

    public function show(Lunch $lunch): LunchResource
    {
        return new LunchResource($lunch);
    }

    public function suitableLunchForDate(Request $request): JsonResponse
    {
        $date = $request->query('date');
        $formatted_date = date('Y-m-d', strtotime($date));

        $lunches = DB::table('lunches')
            ->whereJsonContains('available_days', $formatted_date)
            ->get();

        return response()->json(['lunches' => $lunches]);
    }

    public function update(StoreLunchRequest $request, Lunch $lunch)
    {
        $validatedData = $request->validated();

        $lunch->update($validatedData);

        $lunches = Lunch::where('merchant_id', auth()->user()->id)->paginate(9);

        return LunchResource::collection($lunches);
    }

    public function excelLunches(): JsonResponse
    {

        $merchant = Merchant::where('user_id', auth()->user()->id)->get();

        $filteredLunches = [];
        foreach ($merchant as $merch) {
            $lunches = Lunch::where('merchant_id', $merch->id)->get();

            // Extract "active_range" values from lunches and compare for duplicates
            $activeRanges = [];

            $filteredLunches = collect($lunches)->filter(function ($lunch) use (&$activeRanges) {
                $activeRange = $lunch->active_range;
                if (! in_array($activeRange, $activeRanges)) {
                    $activeRanges[] = $activeRange;

                    return true;
                }

                return false;
            });
        }

        $weekNumbers = FindWeekNumbersAction::execute($filteredLunches);
        $firstWeekOfCurrentMonth = Carbon::now()->startOfMonth()->weekOfYear;

        return response()->json(['lunches' => $filteredLunches, 'weeks' => $weekNumbers, 'first_week' => $firstWeekOfCurrentMonth]);
    }

    public function retrieveStudents(StudentListRequest $request)
    {
        $validated = $request->validated();

        $terminal = Terminal::where('public_key', $validated['public_key'])->first();

        if (! $terminal) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }

        //Validate if request has a "mode" that is either "all" or "search"
        if ($validated['mode'] !== 'all' && $validated['mode'] !== 'search') {
            return response()->json(['error' => 'Invalid request.'], 400);
        } else {
            //if "mode" is "search", validate if it has a search_key and search_value
            if ($validated['mode'] === 'search') {
                if (isset($validated['search_key']) && isset($validated['search_value'])) {
                    //validate if search_key is one of id,card_data,card_number,name
                    if (! in_array($validated['search_key'], ['id', 'card_data', 'card_number', 'name'])) {
                        return response()->json(['error' => 'Invalid request.'], 400);
                    }
                } else {
                    return response()->json(['error' => 'Invalid request.'], 400);
                }
            }
        }

        $message = $validated['per_page'].$validated['page'].$validated['mode'];
        $validSignature = strtoupper(hash('sha512', $message.$terminal->private_key));

        if ($validSignature !== strtoupper($validated['signature'])) {
            return response()->json(['error' => 'Invalid signature.'], 401);
        } else {
            $per_page = $validated['per_page'];
            $page = $validated['page'];
            //Get the merchant through the terminal
            $merchant = Merchant::where('id', $terminal->merchant_id)->first();
            $school = School::where('id', $merchant->school_id)->first();
            if ($validated['mode'] == 'all') {
                $students = Student::where('school_id', $school->id)->get();
            }
            if ($validated['mode'] == 'search') {
                if (in_array($validated['search_key'], ['id', 'card_data', 'card_number'])) {
                    $students = Student::where('school_id', $school->id)->where($validated['search_key'], $validated['search_value'])->get();
                } else {
                    //find students by name. Keep in mind that in the db first_name and last_name is stored in separate columns but API returns one combined name
                    $students = Student::where('school_id', $school->id)->where('first_name', 'like', '%'.$validated['search_value'].'%')->orWhere('last_name', 'like', '%'.$validated['search_value'].'%')->get();
                }
            }
            //Get the total number of students
            $totalStudents = $students->count();
            //Get the total number of pages
            $totalPages = ceil($totalStudents / $per_page);
            //Get the students for the current page from the students collection
            $students = $students->forPage($page, $per_page)->values();
            //->values() is used to reset the keys of the collection
            //Return the students
            return response()->json(['students' => $students, 'total_pages' => $totalPages, 'total_students' => $totalStudents], 200);
        }
    }

    public function retrieveLunch(RetrieveLunchRequest $request)
    {
        $validated = $request->validated();

        $terminal = Terminal::where('public_key', $validated['public_key'])->first();

        if (! $terminal) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }

        $message = $validated['lunch_date'].$validated['card_data'];
        $validSignature = strtoupper(hash('sha512', $message.$terminal->private_key));

        if ($validSignature !== strtoupper($validated['signature'])) {
            return response()->json(['error' => 'Invalid signature.'], 401);
        } else {
            $student = Student::where('card_data', $validated['card_data'])->first();
            if (! $student) {
                return response()->json(['error' => 'Student not found.'], 404);
            }
            $lunches = PeriodicLunch::where('student_id', $student->id)->get();
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
                                $lunch->student = $student->only(['id', 'first_name', 'last_name', 'middle_name']);
                                $originalPlan = Lunch::where('id', $lunch->lunch_id)->first();
                                $lunch->original_plan = $originalPlan->only(['id', 'title', 'description', 'period_length', 'weekdays', 'active_range', 'claimables', 'buffer_item', 'price_period', 'created_at', 'updated_at']);
                                //Update formatted dated from "YYYY-MM-DD HH:MM:SS" to "YYYY.MM.DD"
                                $lunch->start_date = date('Y.m.d', strtotime($lunch->start_date));
                                $lunch->end_date = date('Y.m.d', strtotime($lunch->end_date));

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

        $terminal = Terminal::where('public_key', $validated['public_key'])->first();
        if (! $terminal) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }
        $message = $validated['lunch_date'].$validated['lunch_id'].$validated['claim_name'].$validated['claim_date'];
        $validSignature = strtoupper(hash('sha512', $message.$terminal->private_key));

        if ($validSignature !== strtoupper($validated['signature'])) {
            return response()->json(['error' => 'Invalid signature.'], 401);
        } else {
            $lunch = PeriodicLunch::where('id', $validated['lunch_id'])->first();
            if ($lunch->merchant_id != $terminal->merchant_id) {
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
                                if (! $claimable['claimed']) {
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
