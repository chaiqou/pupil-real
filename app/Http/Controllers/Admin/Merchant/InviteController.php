<?php

namespace App\Http\Controllers\Admin\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invite\CompanyDetailRequest;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\VerificationCodeRequest;
use App\Mail\OnboardingVerification;
use App\Models\Invite;
use App\Models\Merchant;
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
            return route('merchant-verify.email', ['uniqueID' => $invite->uniqueID]);
        }
        //If the invite is not state 4 (Aka before the personal form, but after the user has already been created)
        return route('merchant-personal.form', ['uniqueID' => $invite->uniqueID]);
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

        return view('invite.merchant.setup-account', [
            'uniqueID' => $uniqueID,
            'email' => $invite->email,
        ]);
    }

    public function submitSetupAccount(Request $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $foundUser = User::where('email', $invite->email)->first();
        $request->validate([
            'email' => ['required', 'email', isset($foundUser) ? 'unique:users,email,'.$foundUser->id : 'unique:users,email', 'unique:invites,email,'.$invite->id],
            'password' => [Password::min(8)->mixedCase()->numbers(), 'required'],
        ]);
        isset($foundUser) ? $foundUser->update([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]) : $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ])->assignRole('school');
        $invite->update([
            'email' => isset($foundUser) ? $foundUser->email : $user->email,
            'state' => 3,
        ]);

        return redirect()->route('merchant-personal.form', ['uniqueID' => request()->uniqueID]);
    }

    public function personalForm(): View
    {
        return view('invite.merchant.personal-form', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function submitPersonalForm(PersonalFormRequest $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->first();
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

        return redirect()->route('merchant-company.details', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function companyDetails(): View
    {
        return view('invite.merchant.company-details', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function submitCompanyDetails(CompanyDetailRequest $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->first();
        Merchant::where('user_id', $user->id)->delete();
        Merchant::create([
            'merchant_nick' => $request->merchant_nick,
            'company_legal_name' => $request->company_legal_name,
            'user_id' => $user->id,
            'school_id' => $invite->school_id,
            'billingo_api_key' => null,
            'private_key' => null,
            'public_key' => null,
            'company_details' => json_encode([
                'country' => $request->country,
                'street_address' => $request->street_address,
                'company_name' => $request->company_name,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => (int) $request->zip,
                'VAT' => $request->VAT,
            ]),
        ]);
        $invite->update(['state' => 5]);

        return redirect()->route('merchant-billingo-verify', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function billingoVerify(): View  // just a simple note that function for submitting/verifying billingo will be into the billingo controller
    {
        return view('invite.merchant.billingo-verify', [
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

        return view('invite.merchant.verify-email', [
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

            return redirect()->route('default')->with(['success' => true, 'success_title' => 'Your created your account!', 'success_description' => 'You can now login to your account.']);
        }

        return back()->withErrors(['code' => 'These credentials do not match our records.']);
    }
}
