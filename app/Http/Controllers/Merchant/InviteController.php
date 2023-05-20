<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Invite;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InviteController extends Controller
{
    public static function continueOnboarding($user): string
    {
        $invite = Invite::where('email', $user->email)->first();
        if ($invite->state == 3) {
            return route('merchant-personal.form', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 4) {
            //If the invite is in state 4, redirect to company details
            return route('merchant-company.details', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 5) {
            return route('merchant-setup.stripe', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 6) {
            return route('merchant-billingo.verify', ['uniqueID' => $invite->uniqueID]);
        }
        if ($invite->state == 7) {
            return route('merchant-verify.email', ['uniqueID' => $invite->uniqueID]);
        }

        return route('merchant-setup.account', ['uniqueID' => $invite->uniqueID]);
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
        $user = User::where('email', $invite->email)->first();
        return view('invite.merchant.setup-account', [
            'uniqueID' => $uniqueID,
            'email' => $invite->email,
            'user' => $user,
        ]);
    }

    public function personalForm(): View
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();

        return view('invite.merchant.personal-form', [
            'uniqueID' => request()->uniqueID,
            'user' => $user,
        ]);
    }

    public function companyDetails(): View
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();

        return view('invite.merchant.company-details', [
            'uniqueID' => request()->uniqueID,
            'user' => $user,
        ]);
    }

    public function setupStripe(): View
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();

        return view('invite.merchant.setup-stripe', [
            'uniqueID' => request()->uniqueID,
            'user' => $user,
        ]);
    }

    public function billingoVerify(): View|RedirectResponse  // just a simple note that function for submitting/verifying billingo will be into the billingo controller
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->first();
        $merchant = Merchant::where('user_id', $user->id)->first();
        if (! isset($merchant->stripe_account_id)) {
            return redirect()->back();
        }
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $stripeAccountRetrieve = $stripe->accounts->retrieve(
            $merchant->stripe_account_id
        );
        $invite->update(['state' => 6]);
        if ($stripeAccountRetrieve->charges_enabled) {
            $merchant->stripe_completed = true;

            return view('invite.merchant.billingo-verify', [
                'uniqueID' => request()->uniqueID,
                'user' => $user,
            ]);
        } else {
            return redirect()->back()->withErrors('You dont have an active stripe subscription, so you have to setup it first.');
        }
    }

    public function verifyEmail(): View
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();
        if (! $invite) {
            return view('auth.redirect-template')
                ->with(['header' => 'Invalid Invite', 'title' => 'Invalid invite', 'description' => 'This invite has already been used, or never existed', 'small_description' => 'Try opening your link again, or check if you entered everything correctly.']);
        }

        return view('invite.merchant.verify-email', [
            'uniqueID' => request()->uniqueID,
            'email' => $invite->email,
            'user' => $user,
        ]);
    }
}
