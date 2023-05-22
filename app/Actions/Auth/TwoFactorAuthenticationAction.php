<?php

namespace App\Actions\Auth;

use App\Jobs\Send2FAAuthenticationEmail;

class TwoFactorAuthenticationAction
{
    public static function execute($user)
    {
        $isOnboardingComplete = $user->finished_onboarding === 1;
        $hasValidRole = $user->hasRole(['2fa']);
        if($hasValidRole && $isOnboardingComplete)
        {
            Send2FAAuthenticationEmail::dispatch($user);
        }
    }
}
