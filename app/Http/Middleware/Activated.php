<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Activated
{
    /**
     * Check to see whether user trying to access page is activated
     * else redirect based on whether his account is deactivated
     * or pending activation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->isPendingActivation()) {
            return redirect('/activate');
        }

        if (Auth::user()->isInActive()) {
            Auth::logout();
            return redirect('/login')->withErrors('Your account is no longer active.Contact admin');
        }

        return $next($request);
    }
}
