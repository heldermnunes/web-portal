<?php

namespace App\Modules\Api\Http\Middleware;

use App\Http\Middleware\RedirectIfAuthenticated;

use Illuminate\Support\Facades\Auth;

class ApisRedirectIfAuthenticated extends RedirectIfAuthenticated
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

        //todo return erro json if not authenticated

        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }


        dd('out');
        return $next($request);
    }
}
