<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->active == "2") {
            Auth::logout();
            return redirect()->intended('/account-blocked');
        }
        if (Auth::user() && !Auth::user()->email_verified_at) {
            return redirect()->intended('/pending-status');
        }
        if (Auth::user() && !Auth::user()->active) {
            return redirect()->intended('/pending-approval');
        }
        return $next($request);
    }
}
