<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TwoFactorAuthenticationController extends Controller
{
	public function verify(Request $request)
	{
		if ($request->input('2fa') == Cache::get('2fa'))
		{
			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		}
	}
}
