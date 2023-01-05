<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(request, Closure $next, $guard = null)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }

        switch ($guard)
    {
        case 'admin':
            if (Auth::guard($guard)->check())
            {
                return redirect()->guest('/login/admin');
            }
            break;

            case 'doctor':
                if (Auth::guard($guard)->check())
                {
                    return redirect()->guest('/login/doctor');
                }
                break;

        default:
            if (Auth::guard($guard)->check()) {
                return redirect()->guest(route('login'));
            }
            break;
    }
    return $next($request);
    }
}
