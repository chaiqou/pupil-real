<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ForgotPasswordController extends Controller
{
	public function forgotPasswordForm(): View
	{
		return view('auth.forgot-password');
	}
}
