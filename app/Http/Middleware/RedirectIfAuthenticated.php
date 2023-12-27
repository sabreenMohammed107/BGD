<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


    public function handle($request, Closure $next, $guard = null)
    {
        // if ($guard == "admin" && Auth::guard($guard)->check()) {
        //     return redirect('/admin');
        // }
        // if ($guard == "doctor" && Auth::guard($guard)->check()) {
        //     return redirect('/doctor');
        // }
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/login');
        // }

        // return $next($request);
        $guards = empty($guards) ? ['admin', 'doctor'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard == "doctor"){
                    return Redirect::to('/doctor');
                    // return redirect('/doctor');
                } else{
                    return Redirect::to('/admin');
                    //return redirect('/admin');
                }
            }
        }

        return $next($request);
    }

}
