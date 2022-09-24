<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    private $_app = "";
    private $_page = "pages.transaction.";
    private $_data = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'coin_id' => 'required',
            'units' => 'required',
            'purchase_price' => 'required',
            'purchase_date' => 'required',
            'coin_investment_type'=>'required',
        ]);

        $data = $request->except('_token');
        $user = Auth::user();
        if($data['coin_investment_type']=='sell'){
            $to_check_transaction=DB::select('CALL usp_get_current_transaction_coin_wise('.$user->id.','.$data['coin_id'].')');
            $to_check_buy_total=$to_check_transaction[0]->buy_unit;
            $to_check_sell_total=$to_check_transaction[0]->sell_unit;
            $to_check_amt=$to_check_buy_total-$to_check_sell_total-$data['units'];
            if($to_check_amt<0){
                return redirect()->back()->with('fail', 'Information could not be added.');
            }
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->coin_id = $data['coin_id'];
        $transaction->units = $data['units'];
        $transaction->purchase_price = $data['purchase_price'];
        $transaction->purchase_date = $data['purchase_date'];
        $transaction->investment_type = $data['coin_investment_type'];


        if ($transaction->save()) {
            return redirect()->back()->with('success', 'Purchased the coin.');
        }
        return redirect()->back()->with('fail', 'Information could not be added.');
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
        $transaction=Transaction::find($id);
        $transaction->investment_type=$request->investment_type;
        $transaction->purchase_date=$request->purchase_date;
        $transaction->units=$request->units;
        $total_price=$request->units*$request->purchase_price;
        $transaction->purchase_price=$total_price;
        $transaction->save();
        return response()->json(["success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction=Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaction has been deleted');        
    }
}
