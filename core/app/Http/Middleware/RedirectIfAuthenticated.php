<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if (Auth::guard($guard)->user()->is_verified) {
                
                return redirect()->route('admin.home')->withErrors('You are already logged in');
            }
            else
            {
                return redirect()->route('admin.otp'); 
            }

        }

        return $next($request);
    }
}
