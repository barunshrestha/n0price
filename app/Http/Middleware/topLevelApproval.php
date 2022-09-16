<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class topLevelApproval
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
        $email = $request->user()->email;
        $approval_status = User::where('email', $email)->get('approval_status');
        $status = $approval_status[0]->approval_status;
        if ($status == '0') {
            return $request->expectsJson()
                ? abort(403, 'Your application is not verified.')
                : Redirect::guest(URL::route($redirectToRoute ?: 'approvalpage'));
        }
        return $next($request);
    }
}
