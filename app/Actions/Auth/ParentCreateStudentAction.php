<?php

namespace App\Actions\Auth;

use App\Models\Invite;

class ParentCreateStudentAction
{
    public static function execute($request)
    {
        $user = auth()->user();

        if ($user->finished_onboarding === 1 && $user->students->count() === 0 && $user->hasRole('parent')) {
            self::deleteInviteByEmail($request->email);

            return redirect()->route('parent.create-student', ['user_id' => auth()->user()->id]);
        }
    }

    private static function deleteInviteByEmail($email): void
    {
        $invite = Invite::where('email', $email)->first();
        $invite?->delete();
    }
}
