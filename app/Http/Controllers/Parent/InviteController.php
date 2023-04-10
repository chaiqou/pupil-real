<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Invite;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class InviteController extends Controller
{
    public static function continueOnboarding($user): string
    {
        $invite = Invite::where('email', $user->email)->first();
// Log out the user (So they don't have access to the dashboard)
        Auth::logout();
        if ($invite->state == 3) {
            return route('parent-personal.form', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 4) {
            return route('parent-setup.cards', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 5) {
// If the invite is in state 5, redirect to email verification
            return route('parent-verify.email', ['uniqueID' => $invite->uniqueID]);
        }
        return route('parent-setup.account', ['uniqueID' => $invite->uniqueID]);
    }

    public function setupAccount($uniqueID): View
    {
// Check if the invite exists
        $invite = Invite::where('uniqueID', $uniqueID)->first();
        if (! $invite) {
            return view('auth.redirect-template')
                ->with(['header' => 'Invalid', 'description' => 'Your request is either missing, using an invalid or expired token.', 'title' => 'Invalid', 'small_description' => 'Try opening your link again, or check if you entered everything correctly.']);
        }
        $invite->update(['state' => 2]);
        return view('invite.parent.setup-account', [
            'uniqueID' => $uniqueID,
            'email' => $invite->email,
        ]);
    }

    public function personalForm(): View
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();
        return view('invite.parent.personal-form', [
            'uniqueID' => request()->uniqueID,
            'user' => $user
        ]);
    }
    public function setupCards(): View
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();
        return view('invite.parent.setup-cards', [
            'uniqueID' => request()->uniqueID,
            'user' => $user
        ]);
    }

    public function verifyEmail(): View|RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        if (! $invite) {
            return view('auth.redirect-template')
                ->with(['header' => 'Invalid Invite', 'title' => 'Invalid invite', 'description' => 'This invite has already been used, or never existed', 'small_description' => 'Try opening your link again, or check if you entered everything correctly.']);
        }
        $user = User::where('email', $invite->email)->first();
        $verificationSent = VerificationCode::where('invite_id', $invite->id)->first();
        if (! isset($verificationSent)) {
            return $user->sendVerificationEmail('parent-verify.email');
        } else {
            return view('invite.parent.verify-email', [
                'uniqueID' => request()->uniqueID,
                'email' => $invite->email,
                'user' => $user
            ]);
        }
    }
}
