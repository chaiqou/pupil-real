<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
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
}
