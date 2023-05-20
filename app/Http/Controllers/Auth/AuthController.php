<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\CheckMultipleStudentsAction;
use App\Actions\Auth\CheckSingleStudentAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\ParentCreateStudentAction;
use App\Actions\Auth\TwoFactorAuthenticationAction;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Merchant\InviteController as MerchantInviteController;
use App\Http\Controllers\Parent\InviteController;
use App\Http\Requests\Auth\AuthenticationRequest;
use App\Models\User;
use App\Traits\BrowserNameAndDevice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use BrowserNameAndDevice;

    public function authenticate(AuthenticationRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();
        $passwordMatches = Hash::check($request->password, $user->password);
        if($passwordMatches);
        {
            session()->put('email', $request->email);
            session()->put('password', $request->password);
            if($user->hasRole(['2fa']))
            {
                session()->put('need_to_pass_2fa', true);
                TwoFactorAuthenticationAction::execute($user);
            }
            ParentCreateStudentAction::execute($user);
            if($user->finished_onboarding === 0 && $user->hasRole('parent'))
            {
                $route = InviteController::continueOnboarding($user);

                return redirect($route);
            }

            if ($user->finished_onboarding === 0 && $user->hasRole('school'))
            {
                $route = MerchantInviteController::continueOnboarding($user);

                return redirect($route);
            }

            if ($user->hasRole('parent') && !$user->hasRole('2fa'))
            {
                if (CheckMultipleStudentsAction::execute($user))
                {
                    Auth::login($user);
                    return redirect()->route('parents.dashboard', ['students' => $user->students->all()]);
                } elseif (CheckSingleStudentAction::execute($user)) {
                    Auth::login($user);
                    return redirect()->route('parent.dashboard', ['student_id' => $user->students->first()->id]);
                }
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
