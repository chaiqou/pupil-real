<?php

namespace App\Actions\Auth;

use App\Http\Controllers\Merchant\InviteController as MerchantInviteController;
use Illuminate\Http\RedirectResponse;

class SchoolOnboardingAction
{
    public static function execute($user): RedirectResponse
    {
        $route = MerchantInviteController::continueOnboarding($user);
        session()->forget('email');
        session()->forget('password');
        return redirect($route);
    }

}
