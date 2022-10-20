<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Mail\AccountVerification;
use App\Mail\CustomEmail;
use App\Models\AssetMatrixConstraints;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private $_app = "";
    private $_page = "pages.users.";
    private $_data = [];

    public function __construct()
    {
        $this->_data['page_title'] = 'User';
    }

    public function index()
    {
        $this->_data['users'] = User::all();
        // return ([$this->_data]);
        $this->_data['roles'] = Role::pluck('name', 'id')->prepend('Select Role', '');
        $this->_data['approval_status'] = User::select('approval_status')->distinct()->get();

        return view($this->_page . 'index', $this->_data);
    }
    public function approvalFilter(Request $request)
    {
        $status = $request->approval_status;
        if (is_null($status)) {
            return redirect(route('users.index'));
        }
        $this->_data['users'] = User::where('approval_status', $status)->get();
        $this->_data['roles'] = Role::pluck('name', 'id')->prepend('Select Role', '');
        $this->_data['approval_status'] = User::select('approval_status')->distinct()->get();
        return view($this->_page . 'index', $this->_data);
    }

    public function approveUser($id)
    {
        $user = User::find($id);
        $user->approval_status = '1';
        $user->save();
        Mail::to($user->email)->send(new AccountVerification([
            'body' => 'Your account has been approved. You can now start using NoPrice',
            'user' => $user->name,
        ]));
        return redirect(route('users.index'));
    }


    public function unapproveUser($id)
    {
        $user = User::find($id);
        $user->approval_status = '0';
        $user->save();
        Mail::to($user->email)->send(new AccountVerification([
            'body' => 'Your account has been suspended! Until NoPrice approves you, you cannot use it.',
            'user' => $user->name,
        ]));
        return redirect(route('users.index'));
    }

    public function create()
    {
        $this->_data['roles'] = Role::list();
        return view($this->_page . 'create', $this->_data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'password' => 'required',
        ]);

        $data = $request->except('_token');
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        $user->password = Hash::make($data['password']);
        $user->approval_status = '1';
        if ($user->save()) {
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
            return redirect()->route('users.index')->with('success', 'Your Information has been Added .');
        }
        return redirect()->back()->with('fail', 'Information could not be added .');
    }

    public function edit($id)
    {
        $this->_data['roles'] = Role::list();
        $this->_data['data'] = User::find($id);
        return view($this->_page . 'edit', $this->_data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
        ]);

        $data = array_filter($request->input());

        $user = User::findOrFail($id);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->fill($data);
        if ($user->save()) {
            return redirect()->route('users.index')->with('success', 'Your Information has been Updated .');
        }
        return redirect()->back()->with('fail', 'Information could not be added .');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!in_array($user->role_id, [1])) {
            $user->delete();
            return redirect()->route('users.index')->with('success', "Deleted");
        } else {
            return redirect()->route('users.index')->with('fail', "This role user cannot be deleted .");
        }

        return redirect()->route('users.index')->with('fail', "User could not be deleted.");
    }

    public function checkOldPassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
        ]);
        if (Hash::check($request['old_password'], Auth::user()->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProfile()
    {
        $this->_data['data'] = User::where('id', Auth::user()->id)->first();
        return view($this->_page . 'update-profile', $this->_data);
    }

    public function updateProfileAction(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'new_c_password' => 'required|same:new_password'
        ]);

        if (Hash::check($request['old_password'], Auth::user()->password)) {
            if (User::where(['id' => Auth::user()->id])->update(['password' => Hash::make($request->new_password)])) {
                return redirect()->back()->with('success', 'Your password has been changed .');
            } else {
                return redirect()->back()->with('fail', 'Your password could not be changed .');
            }
        } else {
            return redirect()->back()->with('fail', 'Your Old Password is incorrect');
        }
    }
}
