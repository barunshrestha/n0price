<?php

namespace App\Http\Middleware;

use App\Models\ConnectLoginHistory;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class verifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token_id = $request->token_id;
        if (!$token_id) {
            $code = 404;
            $response = [
                'success' => false,
                'message' => 'User verification failed.',
            ];
            return response()->json($response, $code);
        }
        $User = User::where('token_id', '=', $token_id)->get()->first();

        if ($User && $User !== null) {
            return $next($request);
        } else {
            $code = 404;
            $response = [
                'success' => false,
                'message' => 'User verification failed.',
            ];
            return response()->json($response, $code);
        }
       
        $token = $request->token;
        if (!$token) {
            $code = 404;
            $response = [
                'success' => false,
                'message' => 'User verification failed.',
            ];
            return response()->json($response, $code);
        }

        $ConnectLogin = ConnectLoginHistory::where('token', '=', $token)->get()->first();
        if ($ConnectLogin && $ConnectLogin !== null) {
            return $next($request);
        } else {
            $code = 404;
            $response = [
                'success' => false,
                'message' => 'User verification failed.',
            ];
            return response()->json($response, $code);
        }
    }
}
