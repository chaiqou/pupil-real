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
    public function getStudents(Request $request): ResourceCollection|JsonResponse
    {
        $students = Student::where('user_id', $request->user_id)->latest('created_at')->get();

        return StudentResource::collection($students);
    }
}
