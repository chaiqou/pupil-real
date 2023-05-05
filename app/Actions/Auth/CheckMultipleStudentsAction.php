<?php

namespace App\Actions\Auth;

class CheckMultipleStudentsAction
{
    public function execute()
    {
        return auth()->user()->hasRole('parent') && auth()->user()->students->count() > 1 && session()->get('is_2fa_verified') === true;
    }
}
