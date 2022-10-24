<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Dashboard\ParentController;
use App\Models\User;
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

            if(Auth::user()->hasRole('parent') && Auth::user()->students->count() > 1) {
                return redirect()->route('parents.dashboard', ['students' =>  Auth::user()->students->all()]);
              } else {
                return redirect()->route('dashboard', ['student_id' => Auth::user()->students->first()->id]);
              }
}

		return redirect()->back()->with(['error' => 'error', 'error_title' => 'Authentication failed', 'error_message' => 'The email address or password you entered is incorrect.']);
	}

	public function redirectIfLoggedIn()
	{
	if (Auth::user() && Auth::user()->hasRole('parent') && Auth::user()->students->count() > 1)
	{
		return redirect()->route('parents.dashboard', ['students' =>  Auth::user()->students->all()]);
	}

    return view ('auth/sign-in');
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
