<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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
		return view('sign-in');
	}

	public function logout(Request $request): RedirectResponse
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect(route('default'));
	}
}
