<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\UpdateStudentRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdatePersonalRequest;
use App\Http\Resources\Parent\StudentResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingController extends Controller
{
    public function updatePersonal(UpdatePersonalRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'user_information' => [
                'street_address' => $request->street_address,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ],
        ]);

        return redirect()->back();
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back();
    }

    public function changeTwoFa(): RedirectResponse
    {
        $user = auth()->user();
        if ($user->hasRole('2fa')) {
            $user->removeRole('2fa');
            $user->update([
                'is_verified' => 1,
            ]);
        } else {
            $user->assignRole('2fa');
            $user->sendTwoFactorCode();
        }

        return redirect()->back();
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
