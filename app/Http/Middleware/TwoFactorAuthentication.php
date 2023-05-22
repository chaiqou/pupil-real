<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (session()->has('need_to_pass_2fa')) {
            $excludedRoutes = [
                '2fa.form',
                '2fa.submit',
                '2fa.resend',
                '2fa.logout',
                // Add more excluded routes as needed
            ];

            // Check if the current route is in the excluded routes array
            if (! in_array($request->route()->getName(), $excludedRoutes)) {
                return redirect()->route('2fa.form');
            }
        }

        if (! session()->has('need_to_pass_2fa') && Auth::guest()) {
            $routeName = $request->route()->getName();

            if ($routeName === '2fa.form') {
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
