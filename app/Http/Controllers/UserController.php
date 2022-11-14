<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerification;
use App\Models\AssetMatrixConstraints;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\SelectedPortfolio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
        $users= User::leftjoin('roles','users.role_id','=','roles.id')->get(['users.id','users.name','users.email','users.approval_status','roles.name as role','roles.id as role_id']);
        $this->_data['users'] = $users;
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
        if (Auth::user()->id != $id) {
            $user = User::find($id);
            $user->approval_status = '1';
            $user->save();
            Mail::to($user->email)->send(new AccountVerification([
                'body' => 'Your account has been approved. You can now start using NoPrice',
                'user' => $user->name,
            ]));
            return redirect(route('users.index'))->with('success', 'This user account has been approved. Email has been sent to the user.');
        } else {
            return redirect()->back()->with('fail', 'This user cannot perform the operation.');
        }
    }
    public function unapproveUser($id)
    {
        if (Auth::user()->id != $id) {
            $user = User::find($id);
            $user->approval_status = '0';
            $user->save();
            Mail::to($user->email)->send(new AccountVerification([
                'body' => 'Your account has been suspended! Until NoPrice approves you, you cannot use it.',
                'user' => $user->name,
            ]));
            return redirect(route('users.index'))->with('success', 'This user account has been temporarily suspensed. Email has been sent to the user.');
        } else {
            return redirect()->back()->with('fail', 'This user cannot perform the operation.');
        }
    }

    public function create()
    {
        $this->_data['roles'] = Role::list();
        return view($this->_page . 'create', $this->_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $data = $request->except('_token');
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        $user->password = Hash::make($data['password']);
        $user->approval_status = '1';
        if ($user->save()) {
            $date = Carbon::now();
            $portfolio = new Portfolio();
            $portfolio->user_id = $user->id;
            $portfolio->status = 1;
            $portfolio->save();
            (new AuthController)->create_asset_matrix($user, $portfolio);

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
