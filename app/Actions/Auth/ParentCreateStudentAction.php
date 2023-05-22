<?php

namespace App\Actions\Auth;

use App\Models\Invite;
use Illuminate\Support\Facades\Auth;

class ParentCreateStudentAction
{
    public static function execute($user)
    {

        if ($user->finished_onboarding === 1 && $user->students->count() === 0 && $user->hasRole('parent')) {
            self::deleteInviteByEmail($user->email);
            Auth::login($user);
            return redirect()->route('parent.create-student', ['user_id' => $user->id]);
        }
    }

    private static function deleteInviteByEmail($email): void
    {
        $invite = Invite::where('email', $email)->first();
        $invite?->delete();
    }
}
