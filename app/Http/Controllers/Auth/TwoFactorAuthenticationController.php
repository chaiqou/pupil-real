<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
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


		if ($two_factor_integer == auth()->user()->two_factor_token && auth()->user()->hasRole('parent'))
		{
			auth()->user()->update(['is_verified' => true]);

			return redirect()->route('parent.dashboard', ['student_id' => auth()->user()->students->first()->id]);
		}

        if ($two_factor_integer == auth()->user()->two_factor_token && auth()->user()->hasRole('school'))
        {
            auth()->user()->update(['is_verified' => true]);

            return redirect()->route('school.dashboard');
        }

        if($two_factor_integer == auth()->user()->two_factor_token && auth()->user()->hasRole('admin'))
        {
            auth()->user()->update(['is_verified' => true]);

            return redirect()->route('admin.dashboard');
        }

		return redirect()->back()->withErrors(['error' => 'The two factor authentication code you entered is incorrect.']);
	}

   public function resend(): RedirectResponse
   {
       return auth()->user()->sendTwoFactorCode();
   }
}
