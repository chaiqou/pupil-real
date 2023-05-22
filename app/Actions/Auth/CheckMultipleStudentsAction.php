<?php

namespace App\Actions\Auth;

class CheckMultipleStudentsAction
{
    public static function execute($user): bool
    {
        return $user->hasRole('parent') && $user->students->count() > 1;
    }
}
