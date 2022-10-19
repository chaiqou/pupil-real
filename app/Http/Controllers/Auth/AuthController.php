<?php

namespace App\Http\Controllers\Auth;

use App\Traits\BrowserNameAndDevice;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InviteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\TwoFactorAuthenticationMail;
use App\Http\Requests\Auth\AuthenticationRequest;

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
                return Auth::user()->sendTwoFactorCode();
			}

            if (Auth::user()->finished_onboarding === 1) {
				Auth::user()->update(['finished_onboarding' => 2]);
			}

			if (Auth::user()->finished_onboarding === 0){
				$route = InviteController::continueOnboarding(Auth::user());
				return redirect($route);
			}

			return redirect()->route('dashboard');
		}

		return redirect()->back()->with(['error' => 'error', 'error_title' => 'Authentication failed', 'error_message' => 'The email address or password you entered is incorrect.']);
	}

	public function redirectIfLoggedIn(): View|RedirectResponse
	{
		if (Auth::check()) {
			return redirect(route('dashboard'));
		}
		return view('auth/sign-in');
	}

	public function logout(Request $request): RedirectResponse
	{
		Auth::user()->update(['is_verified' => false, 'two_factor_token' => null]);
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect(route('default'));
	}
}
