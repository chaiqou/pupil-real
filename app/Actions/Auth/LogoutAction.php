
<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LogoutAction
{
  public function execute(Request $request)
  {
      auth()->user()->update(['two_factor_code' => null]);
      session()->put('is_2fa_verified', false);
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();

  }
}
