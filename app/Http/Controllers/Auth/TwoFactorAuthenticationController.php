<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TwoFactorAuthenticationRequest;
use App\Jobs\Send2FAAuthenticationEmail;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TwoFactorAuthenticationController extends Controller
{
    public function form(): View
    {
        auth()->user()->update(['is_verified' => false]); // testing

        return view('auth/two-factor-form');
    }

    public function verify(TwoFactorAuthenticationRequest $request): RedirectResponse
    {
        $two_factor_authentication_code = implode('', $request->input('two_factor_token.*'));
        $two_factor_integer = (int) $two_factor_authentication_code;

        if ($two_factor_integer == auth()->user()->two_factor_token && auth()->user()->hasRole('parent')) {
            auth()->user()->update(['is_verified' => true, 'two_factor_token' => null]);

            return redirect()->route('parents.dashboard', ['students' => auth()->user()->students->all()]);
        }

        if ($two_factor_integer == auth()->user()->two_factor_token && auth()->user()->hasRole('school')) {
            auth()->user()->update(['is_verified' => true, 'two_factor_token' => null]);

            return redirect()->route('school.dashboard');
        }

        if ($two_factor_integer == auth()->user()->two_factor_token && auth()->user()->hasRole('admin')) {
            auth()->user()->update(['is_verified' => true, 'two_factor_token' => null]);

            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['error' => 'The two factor authentication code you entered is incorrect.']);
    }

   public function resend(): RedirectResponse
   {
       Send2FAAuthenticationEmail::dispatch(auth()->user());

       return redirect('two-factor-authentication');
   }

    public function resendForOnboardingUser(Request $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();

        return $user->sendVerificationEmail($request->route);
    }
}
