<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;

class TwoFactorAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole(['2fa', 'school']) && session()->get('is_2fa_verified') === false) {
            return redirect('two-factor-authentication');
        } elseif ($request->user()->hasRole(['2fa', 'admin']) && session()->get('is_2fa_verified') === false) {
            return redirect('two-factor-authentication');
        } elseif ($request->user()->hasRole(['2fa', 'parent']) && session()->get('is_2fa_verified') === false) {
            return redirect('two-factor-authentication');
        }

        return $next($request);
    }
}
