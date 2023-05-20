<?php

namespace App\Actions\Auth;

class CheckSingleStudentAction
{
    public static function execute($user)
    {
        return $user->hasRole(['parent']) && $user->students->count() === 1;
    }
}
