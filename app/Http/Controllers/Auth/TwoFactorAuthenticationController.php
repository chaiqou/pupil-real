<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class TwoFactorAuthenticationController extends Controller
{
	public function form(): View
	{
		return view('auth/two-factor-form');
	}

	public function verify(Request $request)
	{
		if ($request->input('2fa') == Cache::get('2fa'))
		{
			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		}
	}
}
