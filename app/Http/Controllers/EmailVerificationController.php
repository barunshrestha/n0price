<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

class EmailVerificationController extends Controller
{
    public function verify_email_invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : view('auth.verify-email');
    }
    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::find($id);
        if ($request->user()) {
            if ($user->hasVerifiedEmail()) {
                // return redirect()->intended(RouteServiceProvider::VERIFIED.'?verified=1');
                return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
            }
            // return redirect()->intended(RouteServiceProvider::VERIFIED.'?verified=1');
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }
        $user->markEmailAsVerified();
        event(new Verified($user));
        return redirect(route('login'))->with(['success' =>"Email Verified. Please proceed to login." ]);
    }
    public function store(Request $request)
    {

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
