<?php

namespace App\Actions\Auth;

use App\Http\Controllers\Parent\InviteController;
use Illuminate\Http\RedirectResponse;

class ParentOnboardingAction
{
    public static function execute($user): RedirectResponse
    {
        $route = InviteController::continueOnboarding($user);
        session()->forget('email');
        session()->forget('password');
        return redirect($route);

    }
}
