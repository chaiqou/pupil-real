<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\TwoFactorAuthenticationRequest;

class TwoFactorAuthenticationController extends Controller
{
	public function form(): View
	{
		return view('auth/two-factor-form');
	}

	public function verify(TwoFactorAuthenticationRequest $request): RedirectResponse
	{
		$validated = $request->validated();

		if (Auth::user()->two_factor_token === bcrypt($validated['two_factor_token']))
		{
			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		}

		return redirect()->back()->with(['error' => 'error', 'error_title' => 'Authentication failed', 'error_message' => 'The two factor authentication code you entered is incorrect.']);
	}
}
