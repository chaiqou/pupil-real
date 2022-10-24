<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function parentDashboard(): View
    {
        return view('layouts.select-students', ['students' => Auth::user()->students->all()]);
    }

    public function parentStudent($student): View
    {
        $rame = Student::where('id', $student)->first();
        $student = Auth::user()->where('id', $rame->id)->first();
        return view('layouts.dashboard', ['student' => $student]);
    }

}
