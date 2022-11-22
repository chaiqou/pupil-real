<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\StudentResource;
use App\Models\Student;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentController extends Controller
{
    public function index(): ResourceCollection
    {
        $students = Student::with('user')->latest('created_at')->paginate(6);

        return StudentResource::collection($students);
    }
}
