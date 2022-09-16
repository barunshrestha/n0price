<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Dealer;
use App\Models\Exchange;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;

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
        $this->_data['roles'] = Role::pluck('name', 'id')->prepend('Select Role', '');
        return view($this->_page . 'index', $this->_data);
    }

    public function create()
    {
        $this->_data['roles'] = Role::list();
        $this->_data['dealers'] = Dealer::list();
        $this->_data['exchanges'] = Exchange::list();
        return view($this->_page . 'create', $this->_data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $data = $request->except('_token');
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        $user->dealer_id  = $data['dealer_id'];
        $user->exchange_id = $data['exchange_id'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        if ($user->save()) {
            //TODO::EMAIL
            return redirect()->route('users.index')->with('success', 'Your Information has been Added .');
        }
        return redirect()->back()->with('fail', 'Information could not be added .');
    }

    public function edit($id)
    {
        $this->_data['roles'] = Role::list();
        $this->_data['dealers'] = (new CustomerController)->get_dealers_list();
        $this->_data['exchanges'] = Exchange::list();
        $this->_data['data'] = User::find($id);
        return view($this->_page . 'edit', $this->_data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'username' => 'required',
        ]);

        $data = $request->input();
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
        if (!in_array($user->role_id, [1, 2])) {
            $user->delete();
            return redirect()->route('users.index')->with('delete-success', "Deleted");
        } else {
            return redirect()->route('users.index')->with('delete-fail', "This role user cannot be deleted .");
        }

        return redirect()->route('users.index')->with('delete-fail', "User could not be deleted.");
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

    public function checkUsername(Request $request)
    {
        $username = User::where(['username' => $request->username])->pluck('username')->first();
        if (!empty($username)) {
            return false;
        } else {
            return true;
        }
    }

    public function disabledUsersList()
    {
        $this->_data['users'] = User::whereNotIn('role_id', [1, 2])->where('status', 0)->get();
        $this->_data['roles'] = Role::pluck('name', 'id')->prepend('Select Role', '');
        return view($this->_page . 'disabled-users', $this->_data);
    }

    public function enableUser($id)
    {
        if ($id) {
            if (User::where('id', $id)->update(['status' => 1, 'attempts' => 0])) {
                return redirect()->back()->with('success', 'User has been successfully enabled .');
            }
        }
        return redirect()->back()->with('fail', 'User could not be enabled at the moment.');
    }

    public function listUsersLog()
    {
        $this->_data['page_title'] = 'User Track Log';
        $this->_data['activityLogs'] = ActivityLog::orderBy('created_at', 'desc')->get();
        return view($this->_page . 'users-log', $this->_data);
    }

    public function reset($id){
        $User = User::find($id);
        $password = $this->generate_password();
        $length = 12;
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $new_token = substr(str_shuffle($chars),0,$length);
        if(User::where(['id' => $id])->update([
            'password' => Hash::make($password), 
            'token_id' => $new_token,
            'updated' => Carbon::now()->format('Y-m-d h:i:s'),
            'modified_by' => Auth::user()->id
        ])){
            $Dealer = Dealer::where('id','=', $User->dealer_id)->first();
            $message = "Dear Dealer, Your log in credentials for NGM Sathi app has been updated.Password: $password";
            //dd($Dealer->contact);
            $this->sendSMS($Dealer->contact, $message);
            return redirect()->route('users.index')->with('success', 'Your Information has been updated .');
        }
        
        return redirect()->back()->with('fail', 'Information could not be updated .');
    }

    //Fn to generate easy to remember passwords for Sathi Login
    public function generate_password(){
        $words_array_1 = [ 'Expensive','Easytodrive','Registration','Owners','Economical',
                           'Traffic','Vintage','Electric','Speed','Engineered' ,
                           'Faster','Powerful','Extreme','Enhanced','Luxury',
                           'Hybrid','Fast','Classic','Manual','Automatic'];
        $words_array_2 = ['ACHIEVER','DASH','DESTINI','DUET','GLAMOUR',
                          'HUNK','HUNK150R','KARIZMA','KARIZMAZMR','MAESTRO',
                          'PASSIONPRO','PLEASURE','PLEASUREPLUS','SPLENDOR','SUPERSPLENDOR',
                          'SPLENDOR ISMART','XPULSE','XPULSE2004V','XTREME','XTREME200R'];
        $random_number = rand(1001,9999);
        $random_password = $words_array_1[rand(1,19)] . $words_array_2[rand(1,19)]. $random_number;
        return $random_password;


    }
}
