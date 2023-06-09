<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Auth;


class RoleController extends Controller
{
    private $_app = "";
    private $_page = "pages.roles.";
    private $_data = [];

    public function __construct()
    {
        $this->_data['page_title'] = 'Role';
    }

    public function index()
    {
        $this->_data['roles'] = Role::all();
        return view($this->_page . 'index', $this->_data);
    }

    public function create(Request $request)
    {
        return view($this->_page . 'create', $this->_data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'alias' => 'required',
        ]);

        if (Role::create($request->all())) {
            return redirect()->route('roles.index')->with('success', 'Your Information has been Added .');
        }
        return redirect()->back()->with('fail', 'Information could not be added .');
    }

    public function edit($id)
    {
        $this->_data['data'] = Role::find($id);
        return view($this->_page . 'edit', $this->_data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'alias' => 'required'
        ]);

        $data = $request->input();
        $role = Role::findOrFail($id);
        $role->fill($data);
        if ($role->save()) {
            return redirect()->route('roles.index')->with('success', 'Your Information has been Updated .');
        }
        return redirect()->back()->with('fail', 'Information could not be added .');
    }

    public function destroy($id)
    {
        $data = Role::findOrFail($id);
        if (!in_array($id, [1, 2, 3])) {
            if (!empty($data)) {
                if ($data->status == 1) {
                    $data->status = '0';
                    $data->save();
                    $msg = "Role has been successfully disabled.";
                } else {
                    $data->status = '1';
                    $data->save();
                    $msg = "Role has been successfully enabled.";
                }
                return redirect()->route('roles.index')->with('success', $msg);
            }
        } else {
            return redirect()->route('roles.index')->with('delete-fail', "Role cannot be deleted.");
        }

        return redirect()->route('roles.index')->with('fail', "Failure");
    }
}
