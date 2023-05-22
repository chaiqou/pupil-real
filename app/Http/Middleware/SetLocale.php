<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->get('locale') !== null) {
            app()->setLocale(session()->get('locale'));
        } else {
            session()->put('locale', 'hu');
            app()->setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
