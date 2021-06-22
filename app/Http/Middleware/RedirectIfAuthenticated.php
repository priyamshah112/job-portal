<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (!Auth::user()) {
            return $next($request);
        }
        if (Auth::user() && Auth::user()->active == "2") {
            Auth::logout();
            return redirect()->intended('/account-blocked');
        }
        if (Auth::user()->user_type == 'recruiter') {
            return redirect('recruiter/dashboard');
        } else if (Auth::user()->user_type == 'candidate') {
            return redirect('candidate/list-resume');
        } else if (Auth::user()->user_type == 'admin') {
            return redirect('admin/dashboard');
        } else {
            return redirect('/');
        }
        return $next($request);
    }
}
