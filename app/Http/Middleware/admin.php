<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        $role = $request->user()->role_id;
        if ($role != '1') {
            return $request->expectsJson()
                ? abort(403, 'Your application is not verified.')
                : Redirect::guest(URL::route($redirectToRoute ?: 'dashboard'));
        }
        return $next($request);
    }
}
