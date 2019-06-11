<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OTPChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (optional(Auth::guard('admin')->user())->is_verified) {
            
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
