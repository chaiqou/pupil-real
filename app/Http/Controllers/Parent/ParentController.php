<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\ConfirmStudentCreationRequest;
use App\Http\Requests\Parent\StoreStudentRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ParentController extends Controller
{
    public function parentDashboard(): RedirectResponse|View
    {
        if (auth()->user()->is_verified === 0) {
            return redirect()->route('2fa.form');
        }
        if (Auth::user()->hasRole('parent') && Auth::user()->students->count() > 1) {
            return view('layouts.select-students', ['students' => Auth::user()->students->all()]);
        } elseif (Auth::user()->hasRole('parent') && Auth::user()->students->count() === 1) {
            return redirect()->route('parent.dashboard', ['student_id' => Auth::user()->students->first()->id]);
        } else {
            return redirect()->route('parent.create-student', ['user_id' => Auth::user()->id]);
        }
    }

    public function createStudent(): View
    {
        return view('parent.create-student', ['user_id' => Auth::user()->id], [
            'user_id' => auth()->user()->id,
        ]);
    }

    public function storeStudent(StoreStudentRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $student = Student::create([
            'user_id' => $user->id,
            'school_id' => $user->school_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'user_information' => [
                'country' => $request->country,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => (int) $request->zip,
            ],
        ]);

        return redirect()->route('parent.create-student-verify', ['student_id' => $student->id]);
    }

    public function submitStudentCreation(ConfirmStudentCreationRequest $request): RedirectResponse
    {
        if ($request->value === 'confirm') {
            return redirect()->route('parents.dashboard');
        }
        if ($request->value === 'cancel') {
            Student::where('id', request()->student_id)->first()->delete();

            return redirect()->route('parent.create-student', ['user_id' => auth()->user()->id]);
        }

        return redirect()->back();
    }

    public function verifyStudentCreation(): view
    {
        return view('parent.create-student-verify', [
            'user_id' => auth()->user()->id,
        ]);
    }
}
