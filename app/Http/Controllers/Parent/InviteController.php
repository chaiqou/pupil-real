<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\BillingoController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\SetupCardRequest;
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
use Illuminate\Support\Str;
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
        if ($invite->state == 3) {
            return route('parent-personal.form', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 4) {
            return route('parent-setup.cards', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 5) {
            //If the invite is in state 5, redirect to email verification
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
            'school_id' => $invite->school_id,
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
            'user_information' => json_encode([
                'country' => $request->country,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => (int) $request->zip,
            ]),
        ]);
        $userInformation = json_decode($user->user_information);
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_API_SECRET'));
            $stripeCustomerRequest =  $stripe->customers->create([
                'address' => [
                    'city' => $userInformation->city,
                    'country' => $userInformation->country,
                    'line1' => $userInformation->street_address,
                    'postal_code' => $userInformation->zip,
                    'state' => $userInformation->state,
                ],
                'email' => $user->email,
                'name' => $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name
            ]);
        }
    catch(\Stripe\Exception\CardException $e) {
        return redirect()->back()->withErrors("A payment error occurred: {$e->getError()->message}");
    } catch (\Stripe\Exception\InvalidRequestException $e) {
        return redirect()->back()->withErrors('An invalid request occurred.');
    } catch (\Stripe\Exception\ApiConnectionException) {
            return redirect()->back()->withErrors('There was a network problem between your server and Stripe.');
        } catch (\Stripe\Exception\ApiErrorException) {
            return redirect()->back()->withErrors('Something went wrong on Stripe’s end.');
        }
        $user->update([
            'stripe_customer_id' => $stripeCustomerRequest->id,
        ]);
        $invite->update(['state' => 4]);

        return redirect()->route('parent-setup.cards', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function setupCards(): View
    {
        return view('invite.parent.setup-cards', [
            'uniqueID' => request()->uniqueID,
        ]);
    }

    public function submitSetupCards(SetupCardRequest $request): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->firstOrFail();
        if($request->user_response === 'save_card') {
            Str::endsWith(env('APP_URL'), '/') ?
                [$success_url = env('APP_URL').'parent-verify-email/'.$invite->uniqueID, $cancel_url = env('APP_URL').'parent-setup-cards/'.$invite->uniqueID]
                : [$success_url = env('APP_URL').'/'.'parent-verify-email/'.$invite->uniqueID, $cancel_url = env('APP_URL').'/'.'parent-setup-cards/'.$invite->uniqueID];

            try {
                $stripe = new \Stripe\StripeClient(env('STRIPE_API_SECRET'));
                $stripeCreateSessionRequest = $stripe->checkout->sessions->create([
                    'payment_method_types' => ['card'],
                    'mode' => 'setup',
                    'customer' => $user->stripe_customer_id,
                    'success_url' => $success_url,
                    'cancel_url' => $cancel_url,
                ]);
            }
        catch(\Stripe\Exception\CardException $e) {
                return redirect()->back()->withErrors("A payment error occurred: {$e->getError()->message}");
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return redirect()->back()->withErrors('An invalid request occurred.');
            } catch (\Stripe\Exception\ApiConnectionException) {
            return redirect()->back()->withErrors('There was a network problem between your server and Stripe.');
        } catch (\Stripe\Exception\ApiErrorException) {
            return redirect()->back()->withErrors('Something went wrong on Stripe’s end.');
        }
            $user->update([
              'stripe_session_id' => $stripeCreateSessionRequest->id
           ]);
            $invite->update(['state' => 5]);
            return redirect()->to($stripeCreateSessionRequest->url);
        } if($request->user_response === 'dont_save_card') {
        $invite->update(['state' => 5]);
        return $user->sendVerificationEmail('parent-verify.email');
        } else
            $invite->update(['state' => 5]);
            return redirect()->back()->withErrors('Please select you answer');
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
        if(!isset($verificationSent)) {
            return $user->sendVerificationEmail('parent-verify.email');
        } else
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
