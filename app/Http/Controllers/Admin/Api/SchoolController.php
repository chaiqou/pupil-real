<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSchoolRequest;
use App\Http\Resources\School\SchoolResource;
use App\Http\Resources\School\StudentResource;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolController extends Controller
{
    public function index(): ResourceCollection
    {
        $schools = School::latest('created_at')->paginate(5);
        return SchoolResource::collection($schools);
    }

    public function getSchoolsForInvite(): JsonResponse
    {
        $schools = School::all();
        $schoolsArray = [];
        foreach ($schools as $school) {
            $schoolsArray[] = (object)[
                'id' => $school->id,
                'name' => $school->short_name . ' ' . '(' . $school->school_code . ')',
            ];
        }

        return response()->json($schoolsArray);
    }

    public function show(Request $request): SchoolResource
    {
        $school = School::where('id', $request->school_id)->first();

        return new SchoolResource($school);
    }

    public function update(UpdateSchoolRequest $request): ResourceCollection
    {
        $school = School::where('id', $request->school_id)->first();
        $school->update([
            'short_name' => $request->short_name,
            'full_name' => $request->full_name,
            'long_name' => $request->long_name,
            'details' => [
                'street_address' => $request->street_address,
                'email' => $request->email,
                'contact_person' => $request->contact_person,
                'phone_number' => $request->phone_number,
                'mobile_number' => $request->mobile_number,
                'extension' => $request->extension,
            ],
            'school_code' => $request->school_code,
        ]);
        $schools = School::latest('created_at')->get();
        return SchoolResource::collection($schools);
    }
}
