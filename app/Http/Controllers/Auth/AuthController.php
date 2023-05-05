<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AttemptLoginAction;
use App\Actions\Auth\CheckMultipleStudentsAction;
use App\Actions\Auth\CheckSingleStudentAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\OnboardingMerchantAction;
use App\Actions\Auth\ParentCreateStudentAction;
use App\Actions\Auth\TwoFactorAuthenticationAction;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Merchant\InviteController as MerchantInviteController;
use App\Http\Controllers\Parent\InviteController;
use App\Http\Requests\Auth\AuthenticationRequest;
use App\Jobs\Send2FAAuthenticationEmail;
use App\Models\Invite;
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
        $remember = $request->input('remember-me', false);

        if (AttemptLoginAction::execute($validated,$remember)) {
           TwoFactorAuthenticationAction::execute();

          ParentCreateStudentAction::execute($validated);

          OnboardingMerchantAction::execute();

            if (CheckMultipleStudentsAction::execute()) {
                return redirect()->route('parents.dashboard', ['students' => auth()->user()->students->all()]);
            } elseif (CheckSingleStudentAction::execute()) {
                return redirect()->route('parent.dashboard', ['student_id' => auth()->user()->students->first()->id]);
            }
        }

        return redirect()->back()->with(['error' => 'error', 'error_title' => 'Authentication failed', 'error_message' => 'The email address or password you entered is incorrect.']);
    }

    public function redirectIfLoggedIn()
    {
        if (auth()->user() && CheckMultipleStudentsAction::execute()) {
            return redirect()->route('parents.dashboard', ['students' => auth()->user()->students->all()]);
        } elseif (auth()->user() && CheckSingleStudentAction::execute()) {
            return redirect()->route('parent.dashboard', ['student_id' => auth()->user()->students->first()->id]);
        }

        return view('auth.sign-in');
    }

    public function logout(Request $request): RedirectResponse
    {
        LogoutAction::execute($request);
        return redirect(route('default'));
    }
}
