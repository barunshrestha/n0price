<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    private $_app = "";
    private $_page = "pages.coin.";
    private $_data = [];
    public function __construct()
    {
        $this->_data['page_title'] = 'Coin';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->_data['coins'] = Coin::all();
        return view($this->_page . 'index', $this->_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->_page . 'create', $this->_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = $request->except('_token');
        $coin = new Coin();
        $coin->name = $data['name'];
        $coin->status = '1';
        if ($coin->save()) {
            return redirect()->route('coins.index')->with('success', 'Coin Information has been Added .');
        }

        return redirect()->back()->with('fail', 'Coin Information could not be added .');
    }
    public function activeCoin($id)
    {
        $coin = Coin::find($id);
        $coin->status = '1';
        $coin->save();

        return redirect()->route('coins.index')->with('success', 'Coin Information has been updated .');
    }
    public function inactiveCoin($id)
    {
        $coin = Coin::find($id);
        $coin->status = '0';
        $coin->save();
        return redirect()->route('coins.index')->with('success', 'Coin Information has been updated .');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
