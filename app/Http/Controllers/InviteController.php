<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invite\InviteRequest;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\SetupAccountRequest;
use App\Http\Requests\Invite\VerificationCodeRequest;
use App\Mail\InviteUser;
use App\Mail\RandomInteger;
use App\Models\Invite;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InviteController extends Controller
{

    public function index(): View
    {
        return view('invite.user-invite');
    }

	public function sendInvite(InviteRequest $request): RedirectResponse
	{
		$invite = Invite::create([
			'uniqueID'  => Str::random(32),
			'email'     => $request->email,
		]);
		Mail::to($invite->email)->send(new InviteUser($invite));
		$invite->update(['state' => 1]);

		return redirect()->back();
	}

	public function setupAccount($uniqueID): View
	{
		$invite = Invite::where('uniqueID', $uniqueID)->first();
		$invite->update(['state' => 2]);
		return view('invite.setup-account', [
			'uniqueID' => $uniqueID,
		]);
	}

	public function submitSetupAccount(SetupAccountRequest $request): RedirectResponse
	{
		$user = User::create([
			'email'     => $request->email,
			'password'  => bcrypt($request->password),
		]);
		$invite = Invite::where('uniqueID', request()->uniqueID)->first();
		$invite->update([
			'email' => $user->email,
			'state' => 3,
		]);
		return redirect()->route('personal.form', ['uniqueID' => request()->uniqueID]);
	}

	public function personalForm(): View
	{
		return view('invite.personal-form', [
			'uniqueID' => request()->uniqueID,
		]);
	}

	public function submitPersonalForm(PersonalFormRequest $request): RedirectResponse
	{
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
		$user = User::where('email', $invite->email)->first();
		$user->update([
            'last_name'   => $request->last_name,
            'first_name'  => $request->first_name,
            'middle_name' => $request->middle_name,
			'user_information' => [
                'country'  => $request->country,
                'street_address'   => $request->street_address,
                'city'  => $request->city,
                'state'   => $request->state,
                'zip'  => (int)$request->zip,
            ]
		]);
        $invite->update(['state' => 4]);
        $random_integer = VerificationCode::create(['code' => mt_rand(10000000,99999999), 'invite_id' => $invite->id]);
        Mail::to($user->email)->send(new RandomInteger($random_integer));
		return redirect()->route('verify.email', [
            'uniqueID' => request()->uniqueID
        ]);
	}

    public function verifyEmail(): View
    {
        return view('invite.verify-email', [
            'uniqueID' => request()->uniqueID
        ]);
    }

    public function submitVerifyEmail(VerificationCodeRequest $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();
        $input_summary = (int)($request->input('code_each.1') . '' . $request->input('code_each.2') . '' . $request->input('code_each.3') . '' . $request->input('code_each.4') . '' . $request->input('code_each.5') . '' . $request->input('code_each.6') . '' . $request->input('code_each.7') . '' . $request->input('code_each.8'));
        $verification_code = VerificationCode::where('invite_id', $invite->id)->first();
        if($input_summary !== $verification_code->code) {
            return back()->withErrors(['code' => 'These credentials do not match our records.']);
        }
            $user->update(['finished_onboarding' => 1]);
            $invite->delete();
            return redirect()->route('default');
    }
}
