<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && auth()->user()->hasRole('admin')) {
                return redirect(RouteServiceProvider::ADMIN);
            } elseif (Auth::guard($guard)->check() && auth()->user()->hasRole('user')) {
                return redirect(RouteServiceProvider::HOME);
            } elseif (Auth::guard($guard)->check() && auth()->user()->hasRole('parent')) {
                return redirect(RouteServiceProvider::PARENT);
            } elseif (Auth::guard($guard)->check() && auth()->user()->hasRole('school')) {
                return redirect(RouteServiceProvider::SCHOOL);
            }
        }

        return $next($request);
    }
}
