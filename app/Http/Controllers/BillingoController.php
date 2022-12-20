<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invite\BillingoVerificationRequest;
use App\Models\Invite;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BillingoController extends Controller
{
    public function submitBillingoVerify(BillingoVerificationRequest $request): RedirectResponse
    {
        $requestBillingo = Http::withHeaders([
            'X-API-KEY' => $request->api_key
        ])->get('https://api.billingo.hu/v3/utils/time');

        if ($requestBillingo->status() === 401) {
            return redirect()->back()->withErrors('You provided wrong API key');
        }
        if ($requestBillingo->status() === 402) {
            return redirect()->back()->withErrors("You dont have an active Billingo's subscription");
        }
        if ($requestBillingo->status() === 500) {
            return redirect()->back()->withErrors("Something went wrong at Billingo's side");
        }
        if ($requestBillingo->status() === 200) {
            $invite = Invite::where('uniqueID', request()->uniqueID)->first();
            $user = User::where('email', $invite->email)->first();
            $merchant = Merchant::where('user_id', $user->id)->first();
            $merchant->update(['billingo_api_key' => $request->api_key]);
            return redirect()->route('merchant-verify.email', ['uniqueID' => request()->uniqueID]);
        } else {
            return redirect()->back()->withErrors("Something went wrong from pupilpay's side");
        }
    }
}
