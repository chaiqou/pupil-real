<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\UpdateStudentRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\Parent\StudentResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json('Password successfully updated');
    }

    public function updateStudent(UpdateStudentRequest $request): ResourceCollection
    {
        $student = Student::where('id', $request->student_id)->first();
        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'user_information' => [
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'street_address' => $request->street_address,
                'zip' => $request->zip,
            ],
        ]);
        $parent = User::where('id', $student->user_id)->first();
        $students = Student::where('user_id', $parent->id)->latest('created_at')->get();

        return StudentResource::collection($students);
    }
}
