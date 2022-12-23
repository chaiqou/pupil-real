<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\BillingoController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\VerificationCodeRequest;
use App\Mail\OnboardingVerification;
use App\Models\Invite;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class InviteController extends Controller
{
    public static function continueOnboarding($user)
    {
        //Get the invite
        $invite = Invite::where('email', $user->email)->first();
        //Log out the user (So they don't have access to the dashboard)
        Auth::logout();
        if ($invite->state == 4) {
            //If the invite is in state 4, redirect to email verification
            return route('parent-verify.email', ['uniqueID' => $invite->uniqueID]);
        }
        //If the invite is not state 4 (Aka before the personal form, but after the user has already been created)
        return route('parent-personal.form', ['uniqueID' => $invite->uniqueID]);
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

    public function submitSetupAccount(Request $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $foundUser = User::where('email', $invite->email)->first();
        $request->validate([
            'email' => ['required', 'email', isset($foundUser) ? 'unique:users,email,'.$foundUser->id : 'unique:users,email'],
            'password' => [Password::min(8)->mixedCase()->numbers(), 'required'],
        ]);
        isset($foundUser) ? $foundUser->update([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]) : $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ])->assignRole('parent');
        $invite->update([
            'email' => isset($foundUser) ? $foundUser->email : $user->email,
            'state' => 3,
        ]);

        return redirect()->route('parent-personal.form', ['uniqueID' => request()->uniqueID]);
    }

    public function personalForm(): View
    {
        return view('invite.parent.personal-form', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function submitPersonalForm(PersonalFormRequest $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->firstOrFail();
        $user->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'user_information' => [
                'country' => $request->country,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => (int) $request->zip,
            ],
        ]);
        $invite->update(['state' => 4]);

        return redirect()->route('parent-verify.email', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function verifyEmail(): View
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        if (! $invite) {
            return view('auth.redirect-template')
                ->with(['header' => 'Invalid Invite', 'title' => 'Invalid invite', 'description' => 'This invite has already been used, or never existed', 'small_description' => 'Try opening your link again, or check if you entered everything correctly.']);
        }
        $user = User::where('email', $invite->email)->first();
        //Check if invite has VerificationCode
        $verificationCode = VerificationCode::where('invite_id', $invite->id)->first();
        if (! $verificationCode) {
            $verificationCode = VerificationCode::create([
                'invite_id' => $invite->id,
                'code' => random_int(100000, 999999),
            ]);
        }
        Mail::to($user->email)->send(new OnboardingVerification($verificationCode, $user));

        return view('invite.parent.verify-email', [
            'uniqueID' => request()->uniqueID,
            'email' => $invite->email,
        ]);
    }

    public function submitVerifyEmail(VerificationCodeRequest $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();
        $input_summary = implode('', $request->input('code_each.*'));
        $verification_code = VerificationCode::where('invite_id', $invite->id)->first();
        Log::info($input_summary);
        Log::info($verification_code->code);
        if ($verification_code->code == $input_summary) {
            $user->update(['finished_onboarding' => 1]);
            $invite->delete();

            return BillingoController::createParentBillingo($user->id);
        }

        return back()->withErrors(['code' => 'These credentials do not match our records.']);
    }
}
