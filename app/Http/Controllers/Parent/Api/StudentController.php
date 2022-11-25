<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentController extends Controller
{
    public function get(Request $request): ResourceCollection
    {
        $students = Student::where('user_id', $request->user_id)->latest('created_at')->get();

        return StudentResource::collection($students);
    }

    public function show(Request $request): StudentResource
    {
        $student = Student::where('id', $request->student_id)->first();

        return new StudentResource($student);
    }
}
