<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function update(UpdateUserRequest $request): RedirectResponse
    {
      $user = auth()->user();
      $user->update([
          'password' => bcrypt($request->password),
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'middle_name' => $request->middle_name,
          'user_information' => [
              'street_address' => $request->street_address,
              'country' => $request->country,
              'city' => $request->city,
              'state' => $request->state,
              'zip' => $request->zip,
          ]
      ]);

      return redirect()->back();
    }
}
