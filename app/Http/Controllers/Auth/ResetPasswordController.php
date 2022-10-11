<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
	public function resetPasswordForm($token): View
	{
		return view('auth.reset-password', ['token' => $token]);
	}
}
