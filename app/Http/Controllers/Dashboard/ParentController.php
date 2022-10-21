<?php

namespace App\Http\Controllers\Dashboard;

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

    public function parentStudent($student_id): View
    {
        $student = Auth::user()->students->find($student_id);
        return view('layouts.dashboard', ['student' => $student]);
    }

}
