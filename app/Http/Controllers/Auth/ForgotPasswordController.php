<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{
	public function forgotPasswordForm(): View
	{
		return view('auth.forgot-password');
	}

	public function sendForgotPasswordEmail(ForgotPasswordRequest $request): RedirectResponse
	{
		$status = Password::sendResetLink(
			$request->only('email')
		);

		return $status === Password::RESET_LINK_SENT
					? back()->with(['status' => __($status)])
					: back()->withErrors(['email' => __($status)]);
	}
}
