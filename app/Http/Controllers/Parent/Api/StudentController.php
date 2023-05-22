<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentController extends Controller
{
    public function get(): ResourceCollection
    {
        $students = Student::where('user_id', auth()->user()->id)->latest('created_at')->get();

        return StudentResource::collection($students);
    }

    public function show(Request $request): StudentResource
    {
        $student = Student::where('id', $request->student_id)->where('user_id', auth()->user()->id)->first();

        return new StudentResource($student);
    }
}
