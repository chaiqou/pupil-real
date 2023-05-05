<?php

namespace App\Actions\Auth;

use App\Http\Controllers\Merchant\InviteController as MerchantInviteController;
use App\Http\Controllers\Parent\InviteController;

class OnboardingMerchantAction
{
    public function execute()
    {
        if (auth()->user()->finished_onboarding === 0 && auth()->user()->hasRole('parent')) {
            $route = InviteController::continueOnboarding(auth()->user());

            return redirect($route);
        } elseif (auth()->user()->finished_onboarding === 0 && auth()->user()->hasRole('school')) {
            $route = MerchantInviteController::continueOnboarding(auth()->user());

            return redirect($route);
        }
    }
}
