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
	 * @param \Illuminate\Http\Request $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @param string|null ...$guards
	 *
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next, ...$guards)
	{
		$guards = empty($guards) ? [null] : $guards;

		foreach ($guards as $guard)
		{

            switch(Auth::guard($guard)->check())
            {
                case auth()->user()->hasRole('admin'):
                    return redirect(RouteServiceProvider::ADMIN);
                case auth()->user()->hasRole('user'):
                    return redirect(RouteServiceProvider::HOME);
                case auth()->user()->hasRole('parent'):
                    return redirect(RouteServiceProvider::PARENT);
                case auth()->user()->hasRole('school'):
                    return redirect(RouteServiceProvider::SCHOOL);
            }
		}

		return $next($request);
	}
}
