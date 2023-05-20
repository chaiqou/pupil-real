<?php

namespace App\Http\Controllers\Auth;


use App\Actions\Auth\CheckMultipleStudentsAction;
use App\Actions\Auth\CheckSingleStudentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TwoFactorAuthenticationRequest;
use App\Jobs\Send2FAAuthenticationEmail;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthenticationController extends Controller
{
    public function form(): View|RedirectResponse
    {
            return view('auth/two-factor-form');
    }

    public function verify(TwoFactorAuthenticationRequest $request): RedirectResponse
    {
        $request_array = $request->all();
        ksort($request_array['two_factor_code']);
        $two_factor_authentication_code = implode('', $request_array['two_factor_code']);
        $two_factor_integer = (int) $two_factor_authentication_code;

        $user = User::where('email', session()->get('email'))->first();
        if ($two_factor_integer == $user->two_factor_code && $user->hasRole('parent')) {
            Auth::login($user);
            auth()->user()->update(['two_factor_code' => null]);
            session()->forget('need_to_pass_2fa');
            session()->forget('email');
            session()->forget('password');

            if (CheckMultipleStudentsAction::execute($user))
            {
                return redirect()->route('parents.dashboard', ['students' => $user->students->all()]);
            } elseif (CheckSingleStudentAction::execute($user)) {
                return redirect()->route('parent.dashboard', ['student_id' => $user->students->first()->id]);
            }

            return redirect()->route('parents.dashboard', ['students' => auth()->user()->students->all()]);
        }

        if ($two_factor_integer == $user->two_factor_code && $user->hasRole('school')) {
            Auth::login($user);
            auth()->user()->update(['two_factor_code' => null]);
            session()->forget('need_to_pass_2fa');
            session()->forget('email');
            session()->forget('password');

            return redirect()->route('school.dashboard');
        }

        if ($two_factor_integer == $user->two_factor_code && $user->hasRole('admin')) {
            Auth::login($user);
            auth()->user()->update(['two_factor_code' => null]);
            session()->forget('need_to_pass_2fa');
            session()->forget('email');
            session()->forget('password');

            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['error' => 'The two factor authentication code you entered is incorrect.']);
    }

    public function logoutFromTwoFa(): RedirectResponse
    {
        $user = User::where('email', session()->get('email'))->first();
        $user->update([
            'two_factor_code' => null
        ]);
        session()->forget('email');
        session()->forget('password');
        session()->forget('need_to_pass_2fa');
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('default'));
    }

   public function resend(): RedirectResponse
   {
       $user = User::where('email', session()->get('email'))->first();
       Send2FAAuthenticationEmail::dispatch($user);

       return redirect('two-factor-authentication');
   }

    public function resendForOnboardingUser(Request $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();

        return $user->sendVerificationEmail($request->route);
    }

    public function resendForOnboardingUserApi(Request $request): JsonResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();

        return $user->sendVerificationEmailApi($request->route);
    }
}
