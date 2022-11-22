<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\StudentResource;
use App\Models\Merchant;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentController extends Controller
{
    public function getStudents(Request $request): ResourceCollection|JsonResponse
    {
        $students = Student::where('school_id', $request->school_id)->with('user')->latest('created_at')->paginate(6);
        return StudentResource::collection($students);
    }

    public function getDashboardStudents(Request $request): ResourceCollection|JsonResponse
    {
        $merchant = Merchant::where('user_id', $request->school_id)->first();
        $students = Student::where('school_id', $merchant->id)->with('user')->latest('created_at')->paginate(6);
        return StudentResource::collection($students);
    }
}
