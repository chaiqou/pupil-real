<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\BillingoController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\SetupCardRequest;
use App\Http\Requests\Invite\VerificationCodeRequest;
use App\Models\Invite;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class InviteController extends Controller
{
    public function submitSetupAccount(Request $request): JsonResponse
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
            'language' => $request->language,
        ]) : $user = User::create([
            'email' => $request->email,
            'school_id' => $invite->school_id,
            'password' => bcrypt($request->password),
            'language' => $request->language,
        ])->assignRole('parent');
        $invite->update([
            'email' => isset($foundUser) ? $foundUser->email : $user->email,
            'state' => 3,
        ]);
        $url = route('parent-personal.form', ['uniqueID' => request()->uniqueID]);

        return response()->json(['url' => $url]);
    }

    public function submitPersonalForm(PersonalFormRequest $request): JsonResponse
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
                'zip' => $request->zip,
            ]),
        ]);
        $userInformation = json_decode($user->user_information);
        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            $stripeCustomerRequest = $stripe->customers->create([
                'address' => [
                    'city' => $userInformation->city,
                    'line1' => $userInformation->street_address,
                    'postal_code' => $userInformation->zip,
                    'state' => $userInformation->state,
                ],
                'email' => $user->email,
                'name' => $user->last_name.' '.$user->first_name.' '.$user->middle_name,
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            return response()->json("A payment error occurred: {$e->getError()->message}");
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return response()->json('An invalid request occurred.');
        } catch (\Stripe\Exception\ApiConnectionException) {
            return response()->json('There was a network problem between your server and Stripe.');
        } catch (\Stripe\Exception\ApiErrorException) {
            return response()->json('Something went wrong on Stripe’s end.');
        }
        $user->update([
            'stripe_customer_id' => $stripeCustomerRequest->id,
        ]);
        $invite->update(['state' => 4]);

        $url = route('parent-setup.cards', ['uniqueID' => request()->uniqueID]);

        return response()->json(['url' => $url]);
    }

    public function submitSetupCards(SetupCardRequest $request): JsonResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->firstOrFail();
        if ($request->user_response === 'save_card') {
            $success_url = route('parent-verify.email', ['uniqueID' => $invite->uniqueID]);
            $cancel_url = route('parent-setup.cards', ['uniqueID' => $invite->uniqueID]);
            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $stripeCreateSessionRequest = $stripe->checkout->sessions->create([
                    'payment_method_types' => ['card'],
                    'mode' => 'setup',
                    'client_reference_id' => $user->stripe_customer_id,
                    'customer' => $user->stripe_customer_id,
                    'success_url' => $success_url,
                    'cancel_url' => $cancel_url,
                ]);
            } catch (\Stripe\Exception\CardException $e) {
                return response()->json("A payment error occurred: {$e->getError()->message}");
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return response()->json('An invalid request occurred.');
            } catch (\Stripe\Exception\ApiConnectionException) {
                return response()->json('There was a network problem between your server and Stripe.');
            } catch (\Stripe\Exception\ApiErrorException) {
                return response()->json('Something went wrong on Stripe’s end.');
            }
            $user->update([
                'stripe_session_id' => $stripeCreateSessionRequest->id,
            ]);
            $invite->update(['state' => 5]);

            return response()->json(['url' => $stripeCreateSessionRequest->url]);
        } if ($request->user_response === 'dont_save_card') {
            $invite->update(['state' => 5]);

            return $user->sendVerificationEmailApi('parent-verify.email');
        } else {
            $invite->update(['state' => 5]);
        }

        return response()->json(['message' => 'Please select your answer'], 404);
    }

    public function submitVerifyEmail(VerificationCodeRequest $request): JsonResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->firstOrFail();
        $user = User::where('email', $invite->email)->firstOrFail();
        $request_array = $request->all();
        ksort($request_array['verification_code']);
        $email_verification_code = implode('', $request_array['verification_code']);
        $email_verification_integer_code = (int) $email_verification_code;
        $verification_code = VerificationCode::where('invite_id', $invite->id)->first();
        Log::info($email_verification_integer_code);
        Log::info($verification_code->code);
        if ($verification_code->code === $email_verification_integer_code) {
            BillingoController::createOrUpdateParentBillingo($user->id);
            $user->update(['finished_onboarding' => 1]);
            $url = route('default');

            return response()->json(['url' => $url]);
        }

        return response()->json(['message' => 'These credentials do not match our records.'], 404);
    }
}
