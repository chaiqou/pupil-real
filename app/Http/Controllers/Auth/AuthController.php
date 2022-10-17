<?php

namespace App\Http\Controllers\Auth;

use App\Traits\BrowserNameAndDevice;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\TwoFactorAuthenticationMail;
use App\Http\Requests\AuthenticationRequest;

class AuthController extends Controller
{
	use BrowserNameAndDevice;

	public function authenticate(AuthenticationRequest $request): RedirectResponse
	{
		$validated = $request->validated();

		if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->input('remember-me')))
		{
			if (Auth::user()->hasRole(['2fa', 'school']))
			{
				$code = random_int(100000, 999999);

				Auth::user()->update(['two_factor_token' => bcrypt($code)]);

				Mail::to(Auth::user()->email)->send(new TwoFactorAuthenticationMail($code, Auth::user()->first_name, $this->getBrowserName(), $this->getDeviceName(), date('Y')));
			}

			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		}

		return redirect()->back()->with(['error' => 'error', 'error_title' => 'Authentication failed', 'error_message' => 'The email address or password you entered is incorrect.']);
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
