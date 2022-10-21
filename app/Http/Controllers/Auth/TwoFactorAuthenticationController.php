<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\ResendTwoFactorCodeRequest;
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

            $user = User::find(Auth::user()->id);

            if($user->students->count() > 1) {
                return redirect()->route('dashboard');
            }

            // here student is redirected to select students page
			return redirect()->back();
		}

		return redirect()->back()->withErrors(['error' => 'The two factor authentication code you entered is incorrect.']);
	}

   public function resend(): RedirectResponse
   {
       return Auth::user()->sendTwoFactorCode();
   }
}
