<?php

namespace App\Actions\Auth;

use App\Models\Invite;

class ParentCreateStudentAction
{
    public function execute($request)
    {
        $user = auth()->user();

        if ($user->finished_onboarding === 1 && $user->students->count() === 0 && $user->hasRole('parent')) {
            $this->deleteInviteByEmail($request->email);

            return redirect()->route('parent.create-student', ['user_id' => auth()->user()->id]);
        }
    }

      private function deleteInviteByEmail($email): void
      {
          $invite = Invite::where('email', $email)->first();
          $invite?->delete();
      }
}
