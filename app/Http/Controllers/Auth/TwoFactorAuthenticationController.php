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
		$two_factor_authentication_code = implode('', $request->input('two_factor_token.*'));
		$two_factor_integer = (int) $two_factor_authentication_code;

		if ($two_factor_integer == Auth::user()->two_factor_token)
		{
			Auth::user()->update(['is_verified' => true]);
			return redirect()->route('dashboard');
		}

		return redirect()->back()->with(['error' => 'error', 'error_title' => 'Authentication failed', 'error_message' => 'The two factor authentication code you entered is incorrect.']);
	}
}
