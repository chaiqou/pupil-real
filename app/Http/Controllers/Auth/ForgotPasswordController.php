<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
	public function forgotPasswordForm(): View
	{
		return view('auth.forgot-password');
	}

	public function sendForgotPasswordEmail(ForgotPasswordRequest $request): RedirectResponse
	{
		$token = Str::random(64);

		DB::table('password_resets')->insert([
			'email'      => $request->email,
			'token'      => $token,
			'created_at' => now(),
		]);

		Mail::to($request->email)->send(new ForgotPasswordMail($token));

		return redirect()->route('default');
	}
}
