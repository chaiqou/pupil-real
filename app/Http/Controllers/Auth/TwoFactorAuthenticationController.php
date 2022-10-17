<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthenticationController extends Controller
{
	public function form(): View
	{
		return view('auth/two-factor-form');
	}

	public function verify(Request $request)
	{
		if ($request->input('2fa') == auth()->user()->two_factor_token)
		{
			Auth::user()->update(['2fa' => null]);
			$request->session()->regenerate();
			return redirect(route('dashboard'));
		}
	}
}
