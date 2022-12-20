<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Admin\Merchant\InviteController as MerchantInviteController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Parent\InviteController;
use App\Http\Requests\Auth\AuthenticationRequest;
use App\Traits\BrowserNameAndDevice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use BrowserNameAndDevice;

    public function authenticate(AuthenticationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->input('remember-me'))) {
            if (auth()->user()->hasRole(['2fa', 'school', 'admin'])) {
                return auth()->user()->sendTwoFactorCode();
            }

            if (auth()->user()->finished_onboarding === 1 && auth()->user()->students->count() === 0 && auth()->user()->hasRole('parent')) {
                return redirect()->route('parent.create-student', ['user_id' => auth()->user()->id]);
            }

            if (auth()->user()->finished_onboarding === 0 && auth()->user()->hasRole('parent')) {
                $route = InviteController::continueOnboarding(auth()->user());
                return redirect($route);
            } elseif (auth()->user()->finished_onboarding === 0 && auth()->user()->hasRole('school')) {
                $route = MerchantInviteController::continueOnboarding(auth()->user());
                return redirect($route);
            }

            if (auth()->user()->hasRole('parent') && auth()->user()->students->count() > 1 && auth()->user()->is_verified === 1) {
                return redirect()->route('parents.dashboard', ['students' => auth()->user()->students->all()]);
            } elseif (auth()->user()->hasRole('parent') && auth()->user()->students->count() === 1 && auth()->user()->is_verified === 1) {
                return redirect()->route('parent.dashboard', ['student_id' => auth()->user()->students->first()->id]);
            }
        }

        return redirect()->back()->with(['error' => 'error', 'error_title' => 'Authentication failed', 'error_message' => 'The email address or password you entered is incorrect.']);
    }

    public function redirectIfLoggedIn()
    {
        if (auth()->user() && auth()->user()->hasRole('parent') && auth()->user()->students->count() > 1 && auth()->user()->is_verified === 1) {
            return redirect()->route('parents.dashboard', ['students' => auth()->user()->students->all()]);
        } elseif (auth()->user() && auth()->user()->hasRole('parent') && auth()->user()->students->count() === 1 && auth()->user()->is_verified === 1) {
            return redirect()->route('parent.dashboard', ['student_id' => auth()->user()->students->first()->id]);
        }

        return view('auth.sign-in');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->user()->update(['is_verified' => false, 'two_factor_token' => null]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('default'));
    }
}
