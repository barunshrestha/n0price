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
        $this->_data['coins'] = Coin::paginate(500);
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

    public function sync_coin()
    {
        // $url = "https://pro-api.coingecko.com/api/v3/coins/markets?x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX&vs_currency=usd";
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $coins = json_decode($response, true);

        // foreach ($coins as $value) {
        //     Coin::query()->updateOrCreate([
        //         'name' => $value['name'],
        //         'coin_id' => $value['id'],
        //         'symbol' => $value['symbol'],
        //         'image' => $value['image'],
        //     ]);
        // }

        $url='https://pro-api.coingecko.com/api/v3/coins/list?include_platform=false&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $coins = json_decode($response, true);       
        
        foreach ($coins as $value) {
            $coin_id=$value['id'];
            $image_url= 'https://pro-api.coingecko.com/api/v3/coins/'.$coin_id.'/history?date=22-09-2022&localization=false&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $image_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $image_response = curl_exec($ch);
            curl_close($ch);
            $image_coin = json_decode($image_response, true);
            $image_name=$image_coin['image']['small'];

            Coin::query()->updateOrCreate([
                'name' => $value['name'],
                'coin_id' => $value['id'],
                'symbol' => $value['symbol'],
                'image'=>$image_name,
            ]);
        }
        return redirect()->back()->with('success', 'Coin Synced Successfully');
    }
}
