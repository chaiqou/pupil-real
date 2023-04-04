<?php

namespace App\Http\Controllers\Merchant\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invite\CompanyDetailRequest;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\VerificationCodeRequest;
use App\Models\Invite;
use App\Models\Merchant;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class InviteController extends Controller
{
    public function submitSetupAccount(Request $request): JsonResponse
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
            'language' => $request->language
        ]) : $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'language' => $request->language
        ])->assignRole('school');
        $invite->update([
            'email' => isset($foundUser) ? $foundUser->email : $user->email,
            'state' => 3,
        ]);

        $url = route('merchant-personal.form', ['uniqueID' => request()->uniqueID]);
        return response()->json(['url' => $url]);
    }

    public function submitPersonalForm(PersonalFormRequest $request): JsonResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->first();
        $user->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'school_id' => $invite->school_id,
            'user_information' => [
                'country' => $request->country,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => (int) $request->zip,
            ],
        ]);
        $invite->update(['state' => 4]);

        $url = route('merchant-company.details', ['uniqueID' => request()->uniqueID]);
        return response()->json(['url' => $url]);
    }

    public function submitCompanyDetails(CompanyDetailRequest $request): JsonResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->first();
        $userPersonalInfo = json_decode($user->user_information);
        $merchant = Merchant::updateOrCreate(['user_id' => $user->id], [
            'finished_onboarding' => 0,
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
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            if ($request->business_type === 'individual') {
                $stripeAccount = $stripe->accounts->create([
                    'type' => 'express',
                    'country' => $request->country,
                    'email' => $user->email,
                    'business_type' => $request->business_type,
                    'business_profile' => [
                        'product_description' => 'Merchant for the PupilPay Platform.',
                    ],
                    'company' => [
                        'address' => [
                            'city' => $request->city,
                            'country' => $request->country,
                            'line1' => $request->street_address,
                            'postal_code' => $request->zip,
                            'state' => $request->state,
                        ],
                        'name' => $request->company_legal_name,
                        'vat_id' => $request->VAT,
                    ],
                    'individual' => [
                        'address' => [
                            'city' => $userPersonalInfo->city,
                            'country' => $userPersonalInfo->country,
                            'line1' => $userPersonalInfo->street_address,
                            'postal_code' => $userPersonalInfo->zip,
                            'state' => $userPersonalInfo->state,
                        ],
                        'email' => $user->email,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                    ],
                ]);
            } else {
                $stripeAccount = $stripe->accounts->create([
                    'type' => 'express',
                    'country' => $request->country,
                    'email' => $user->email,
                    'business_type' => $request->business_type,
                    'business_profile' => [
                        'product_description' => 'Merchant for the PupilPay Platform.',
                    ],
                    'company' => [
                        'address' => [
                            'city' => $request->city,
                            'country' => $request->country,
                            'line1' => $request->street_address,
                            'postal_code' => $request->zip,
                            'state' => $request->state,
                        ],
                        'name' => $request->company_legal_name,
                        'vat_id' => $request->VAT,
                    ],
                ]);
            }
        } catch(\Stripe\Exception\CardException $e) {
            return response()->json("A payment error occurred: {$e->getError()->message}");
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return response()->json('An invalid request occurred.');
        } catch (\Stripe\Exception\ApiConnectionException) {
            return response()->json('There was a network problem between your server and Stripe.');
        } catch (\Stripe\Exception\ApiErrorException) {
            return response()->json('Something went wrong on Stripe’s end.');
        }
        $merchant->update([
            'stripe_account_id' => $stripeAccount->id,
        ]);
        $invite->update(['state' => 5]);
        $url = route('merchant-setup.stripe', ['uniqueID' => request()->uniqueID]);
        return response()->json(['url' => $url]);
    }

    public function submitSetupStripe(): JsonResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->first();
        $merchant = Merchant::where('user_id', $user->id)->first();
        Str::endsWith(env('APP_URL'), '/') ?
            [$refresh_url = env('APP_URL').'merchant-setup-stripe/'.$invite->uniqueID, $return_url = env('APP_URL').'merchant-billingo-verify/'.$invite->uniqueID]
            : [$refresh_url = env('APP_URL').'/'.'merchant-setup-stripe/'.$invite->uniqueID, $return_url = env('APP_URL').'/'.'merchant-billingo-verify/'.$invite->uniqueID];

        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $stripeAccountLink = $stripe->accountLinks->create([
                'account' => $merchant->stripe_account_id,
                'refresh_url' => $refresh_url,
                'return_url' => $return_url,
                'type' => 'account_onboarding',
            ]);
        } catch(\Stripe\Exception\CardException $e) {
            return response()->json("A payment error occurred: {$e->getError()->message}");
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return response()->json('An invalid request occurred.');
        } catch (\Stripe\Exception\ApiConnectionException) {
            return response()->json('There was a network problem between your server and Stripe.');
        } catch (\Stripe\Exception\ApiErrorException) {
            return response()->json('Something went wrong on Stripe’s end.');
        }

        return response()->json(['url' => $stripeAccountLink->url]);
    }

    public function submitVerifyEmail(VerificationCodeRequest $request): JsonResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();
        $merchant = Merchant::where('user_id', $user->id)->first();
        $request_array = $request->all();
        ksort($request_array['verification_code']);
        $email_verification_code = implode('', $request_array['verification_code']);
        $email_verification_integer_code = (int) $email_verification_code;
        $verification_code = VerificationCode::where('invite_id', $invite->id)->first();
        Log::info($email_verification_integer_code);
        Log::info($verification_code->code);
        if ($verification_code->code === $email_verification_integer_code) {
            $user->update(['finished_onboarding' => 1]);
            $merchant->update(['finished_onboarding' => 1]);
            $invite->delete();

            return response()->json(['url' => route('default')]);
           // return redirect()->route('default')->with(['success' => true, 'success_title' => 'Your created your account!', 'success_description' => 'You can now login to your account.']);
        }
        return response()->json(['message' => 'These credentials do not match our records.'], 404);
    }
}
