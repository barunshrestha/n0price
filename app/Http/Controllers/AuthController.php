<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AssetMatrixConstraints;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $_app = "";
    private $_page = null;
    private $_data = [];

    public function _construct()
    {
    }

    public function signup(Request $request)
    {
        return view('layout.signup');
    }

    public function signupAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
        return redirect()->back()->with(['fail' =>"User Creation Failed" ]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approval_status'=>'1'
        ]);
        $date = Carbon::now();
        $data = [
            ['user_id' => $user->id, 'risk' => 'Very High', 'market_cap' => '<25M', 'color' => '#e9fac8', 'created_at' => $date, 'updated_at' => $date],
            ['user_id' => $user->id, 'risk' => 'High', 'market_cap' => '25M - 250M', 'color' => '#fff3bf', 'created_at' => $date, 'updated_at' => $date],
            ['user_id' => $user->id, 'risk' => 'Medium', 'market_cap' => '250M - 1B', 'color' => '#d3f9d8', 'created_at' => $date, 'updated_at' => $date],
            ['user_id' => $user->id, 'risk' => 'Low', 'market_cap' => '1B - 25B', 'color' => '#ffd8a8', 'created_at' => $date, 'updated_at' => $date],
            ['user_id' => $user->id, 'risk' => 'Very Low', 'market_cap' => '>25B', 'color' => '#ffa8a8', 'created_at' => $date, 'updated_at' => $date],
        ];
        AssetMatrixConstraints::insert($data);

        event(new Registered($user));

        return redirect(route('login'))->with(['success' =>"User Registration Successful" ]);
    }

    public function login(Request $request)
    {
        return view('layout.login');
    }

    public function loginAction(Request $request)
    {
        // $request->authenticate();
        // $request->session()->regenerate();
        // return redirect()->intended(RouteServiceProvider::HOME);

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withInput($request->only('username'))->with(['fail' => 'Credentials did not match our record']);
    }

    public function logout(Request $request)
    {
        $user_id = Auth::user()->id;

        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
    public function approvalPending()
    {
        if (Auth::user()->approval_status == 1) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        return view('auth.approval_page');
    }
}
