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

	public function sendForgotPasswordMail(ForgotPasswordRequest $request): RedirectResponse
	{
		$token = Str::random(64);

		DB::table('password_resets')->insert([
			'email'      => $request->email,
			'token'      => $token,
			'created_at' => now(),
		]);

		Mail::to($request->email)->send(new ForgotPasswordMail($token));

		return redirect()->route('forgot.redirect');
	}

	public function forgotRedirect(): View
	{
		return view('auth.redirect-template')
		->with(['header' => 'Email sent', 'title' => 'Check your email', 'description' => 'Check your email address for instructions on how to reset your password', 'small_description' => "If you can't find the email in a few minutes, check your spam folder."]);
	}
}
