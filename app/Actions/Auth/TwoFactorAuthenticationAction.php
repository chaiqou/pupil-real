<?php

namespace App\Actions\Auth;

use App\Jobs\Send2FAAuthenticationEmail;

class TwoFactorAuthenticationAction
{
    public function execute()
    {
        $user = auth()->user();
        $isOnboardingComplete = $user->finished_onboarding === 1;
        $hasValidRoles = $user->hasRole(['2fa', 'school', 'admin']);

        if ($hasValidRoles && $isOnboardingComplete) {
            Send2FAAuthenticationEmail::dispatch($user);
            session()->put('is_2fa_verified', false);

            return redirect('two-factor-authentication');
        }
    }
}
