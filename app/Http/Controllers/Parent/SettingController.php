<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePersonalRequest;
use App\Jobs\Send2FAAuthenticationEmail;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function updatePersonal(UpdatePersonalRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'user_information' => [
                'street_address' => $request->street_address,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ],
        ]);

        return redirect()->back();
    }

    public function changeTwoFa(): RedirectResponse
    {
        $user = auth()->user();
        if ($user->hasRole('2fa')) {
            $user->removeRole('2fa');
            session()->put('is_2fa_verified', true);
        } else {
            Send2FAAuthenticationEmail::dispatch(auth()->user());

            return redirect('two-factor-authentication');
        }

        return redirect()->back();
    }
}
