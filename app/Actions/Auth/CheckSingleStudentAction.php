<?php

namespace App\Actions\Auth;

class CheckSingleStudentAction
{
    public static function execute($user): bool
    {
        return $user->hasRole('parent') && $user->students->count() === 1 && session()->get('is_2fa_verified') === true;
    }
}
