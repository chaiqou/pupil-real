<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function parentDashboard(): RedirectResponse|View
    {

        if(Auth::user()->hasRole('parent') && Auth::user()->students->count() > 1) {
            return view('layouts.select-students', ['students' =>  Auth::user()->students->all()]);
          } else {
            return redirect()->route('parent.dashboard', ['student_id' => Auth::user()->students->first()->id]);
          }

    }

}
