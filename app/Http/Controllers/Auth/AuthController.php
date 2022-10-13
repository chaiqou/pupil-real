<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AuthenticationRequest;

class AuthController extends Controller
{
	public function authenticate(AuthenticationRequest $request): RedirectResponse
	{
		Log::info('Attempting to authenticate user');
		Log::info($request->all());

		$validated = $request->validated();

		if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->input('remember-me')))
		{
			Log::info('Authentication successful');
			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		}
		Log::info('Authentication failed at' . date('Y-m-d H:i:s'));

		return back()->withErrors(['email' => 'These credentials do not match our records.']);
	}

	public function redirectIfLoggedIn(): View|RedirectResponse
	{
		if (Auth::check())
		{
			return redirect(route('dashboard'));
		}
		return view('auth/sign-in');
	}

	public function logout(Request $request): RedirectResponse
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect(route('default'));
	}
}
