<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index(): View
	{
		return view('dashboard')->with('page', 'Dashboard');
	}

}
