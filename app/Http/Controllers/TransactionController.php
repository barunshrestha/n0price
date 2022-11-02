<?php

namespace App\Http\Controllers;

use App\Models\AssetMatrixConstraints;
use App\Models\Coin;
use App\Models\Portfolio;
use App\Models\SelectedPortfolio;
use App\Models\Sell_log;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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
            'coin_investment_type' => 'required',
        ]);

        $data = $request->except('_token');
        $user = Auth::user();
        $selected_portfolio = Portfolio::where("user_id", $user->id)->where('status', 1)->get('id');
        if ($data['coin_investment_type'] == 'sell') {
            $to_check_transaction = DB::select('CALL usp_get_current_transaction_coin_wise(' . $user->id . ',' . $data['coin_id'] . ',' . $selected_portfolio[0]->id . ')');
            $to_check_buy_total = $to_check_transaction[0]->buy_unit;
            $to_check_sell_total = $to_check_transaction[0]->sell_unit;
            $to_check_amt = $to_check_buy_total - $to_check_sell_total - $data['units'];
            if ($to_check_amt < 0) {
                return redirect()->back()->with('fail', 'Information could not be added.');
            }
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->coin_id = $data['coin_id'];
        $transaction->units = $data['units'];
        $transaction->purchase_price_per_unit = $data['purchase_price'];
        $transaction->purchase_date = $data['purchase_date'];
        $transaction->investment_type = $data['coin_investment_type'];
        $transaction->purchase_price = $data['purchase_price'] * $data['units'];
        $transaction->portfolio_id = $data['portfolio_id'];


        // logic for partial subtranction

        // if ($data['coin_investment_type'] == 'sell') {
        //     $total_sell_unit = (int)$data['units'];
        //     $sell_unit_price = $data['purchase_price'] / $data['units'];
        //     $current_transactions = Transaction::where('user_id', '=', Auth::user()->id)
        //         ->where('partial_units_debited', '<', 'units')
        //         ->where('investment_type', '=', 'buy')
        //         ->where('coin_id', '=', $data['coin_id'])->get();
        //     if ($total_sell_unit > 0) {
        //         for ($i = 0; $i < count($current_transactions); $i++) {
        //             $current_transaction = $current_transactions[$i];
        //             $purchase_unit_price = $current_transaction->purchase_price / $current_transaction->units;
        //             $profit_loss_rate = $sell_unit_price - $purchase_unit_price;
        //             $total_units = $current_transaction->units;
        //             $total_debited_units = $current_transaction->partial_units_debited;
        //             $slot_units_available = $total_units - $total_debited_units;
        //             $profit_earned = $current_transaction->profit_earned;
        //             if ($slot_units_available > 0) {
        //                 if ($slot_units_available >= $total_sell_unit) {
        //                     if ($total_sell_unit > 0) {
        //                         $current_transaction->update([
        //                             "partial_units_debited" => $total_debited_units + $total_sell_unit,
        //                             "profit_earned" => $profit_earned + $profit_loss_rate * $total_sell_unit
        //                         ]);
        //                         $sell_log = new Sell_log();
        //                         $sell_log->transaction_id = $current_transaction->id;
        //                         $sell_log->profit_loss = $profit_loss_rate;
        //                         $sell_log->units_debited = $total_sell_unit;
        //                         $sell_log->save();
        //                         $total_sell_unit = $total_sell_unit - $total_debited_units;
        //                         break;
        //                     }
        //                 } elseif ($slot_units_available < $total_sell_unit) {
        //                     if ($total_sell_unit > 0) {

        //                         $current_transaction->update([
        //                             "partial_units_debited" => $total_debited_units + $slot_units_available,
        //                             "profit_earned" => $profit_earned + $profit_loss_rate * $slot_units_available
        //                         ]);
        //                         $sell_log = new Sell_log();
        //                         $sell_log->transaction_id = $current_transaction->id;
        //                         $sell_log->profit_loss = $profit_loss_rate;
        //                         $sell_log->units_debited = $slot_units_available;
        //                         $sell_log->save();
        //                         $total_sell_unit = $total_sell_unit - $slot_units_available;
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        if ($transaction->save()) {
            if ($data['coin_investment_type'] == 'buy') {
                return redirect()->back()->with('success', 'Successfully purchased the coin.');
            }
            if ($data['coin_investment_type'] == 'sell') {
                // $current_transaction=Transaction::where('user_id','=',Auth::user()->id)->where('partial_units_debited','<','units');
                return redirect()->back()->with('success', 'Successfully sold the coin.');
            }
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
        $transaction = Transaction::find($id);
        $user = User::find($transaction->user_id);
        $investment_type = $request->investment_type;
        $given_coin_id = $transaction->coin_id;
        $selected_portfolio = Portfolio::where("user_id", $user->id)->where('status', 1)->get('id');
        if ($investment_type == 'sell') {
            $to_check_transaction = DB::select('CALL usp_get_current_transaction_coin_wise(' . $user->id . ',' . $given_coin_id . ',' . $selected_portfolio[0]->id .  ')');
            $to_check_buy_total = $to_check_transaction[0]->buy_unit;
            $to_check_sell_total = $to_check_transaction[0]->sell_unit ? $to_check_transaction[0]->sell_unit : 0;
            $to_check_amt = $to_check_buy_total - $to_check_sell_total - $request->units;
            if ($to_check_amt < 0) {
                return response()->json(["success" => false, "response" => "Information couldn't be updated successfully"]);
            }
        }
        $transaction->investment_type = $investment_type;
        $transaction->purchase_date = $request->purchase_date;
        $transaction->units = $request->units;
        $total_price = $request->units * $request->purchase_price;
        $transaction->purchase_price = $total_price;
        $transaction->purchase_price_per_unit = $request->purchase_price;
        $transaction->save();
        return response()->json(["success" => true, "response" => "Information updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $transaction = Transaction::findOrFail($request->id);
        $transaction->delete();
        return response()->json(["msg" => "Your response has been deleted"]);
    }



    // backup
    public function profit_calculation()
    {
        $user = Auth::user();
        $coins_available = DB::select('select distinct name from vw_buy_transactions where user_id = ?', [$user->id]);
        $buy_transactions = DB::select('select units,name,purchase_price from vw_buy_transactions where user_id = ? order by name asc', [$user->id]);
        $sell_transactions = DB::select('select units,name,purchase_price from vw_sell_transactions where user_id = ? order by name asc', [$user->id]);
        // return([$sell_transactions]);
        $total_profit = array();


        $current_transactions = array();
        foreach ($coins_available as $coins) {
            array_push($total_profit, array($coins->name, 0));
        }


        foreach ($buy_transactions as $b_t) {
            array_push($current_transactions, array($b_t->name, $b_t->units, $b_t->purchase_price, 0, 0));
        }


        $total_sell_units = array();
        foreach ($sell_transactions as $s_t) {
            array_push($total_sell_units, array($s_t->name, $s_t->units, $s_t->purchase_price));
        }
        foreach ($total_sell_units as $sell_unit) {
            $total_sell_unit = $sell_unit[1];
            $sell_unit_price = $sell_unit[2] / $sell_unit[1];
            $sell_unit_coin_name = $sell_unit[0];

            if ($total_sell_unit > 0) {
                for ($i = 0; $i < count($current_transactions); $i++) {
                    if ($sell_unit_coin_name == $current_transactions[$i][0]) {
                        $current_transaction = $current_transactions[$i];
                        $purchase_unit_price = $current_transaction[2] / $current_transaction[1];
                        $profit_loss_rate = $sell_unit_price - $purchase_unit_price;
                        $total_units = $current_transaction[1];
                        $total_debited_units = $current_transaction[3];
                        $slot_units_available = $total_units - $total_debited_units;
                        $profit_earned = $current_transaction[4];
                        if ($slot_units_available > 0) {
                            if ($slot_units_available >= $total_sell_unit) {
                                if ($total_sell_unit > 0) {
                                    $current_transactions[$i][3] = $total_debited_units + $total_sell_unit;
                                    $current_transactions[$i][4] = $profit_earned + $profit_loss_rate * $total_sell_unit;
                                    $total_sell_unit = $total_sell_unit - $total_debited_units;
                                    break;
                                }
                            } elseif ($slot_units_available < $total_sell_unit) {
                                if ($total_sell_unit > 0) {
                                    $current_transactions[$i][3] = $total_debited_units + $slot_units_available;
                                    $current_transactions[$i][4] = $profit_earned + $profit_loss_rate * $slot_units_available;
                                    $total_sell_unit = $total_sell_unit - $slot_units_available;
                                }
                            }
                        }
                    }
                }
            }
        }
        // return ([$current_transactions]);
        for ($i = 0; $i < count($total_profit); $i++) {
            $profit = $total_profit[$i];
            foreach ($current_transactions as $ct) {
                if ($profit[0] == $ct[0]) {
                    $total_profit[$i][1] = $total_profit[$i][1] + $ct[4];
                }
            }
        }
        return response()->json(["success" => true, "data" => $total_profit]);
    }


    public function assign_asset_matrix_constraints()
    {
        $users = User::all('id');
        foreach ($users as $user) {
            if (AssetMatrixConstraints::where('user_id', $user->id)->count() == 0) {
                $date = Carbon::now();
                $data = [
                    ['user_id' => $user->id, 'risk' => 'Very High', 'market_cap' => '<25M', 'color' => '#e9fac8', 'created_at' => $date, 'updated_at' => $date],
                    ['user_id' => $user->id, 'risk' => 'High', 'market_cap' => '25M - 250M', 'color' => '#fff3bf', 'created_at' => $date, 'updated_at' => $date],
                    ['user_id' => $user->id, 'risk' => 'Medium', 'market_cap' => '250M - 1B', 'color' => '#d3f9d8', 'created_at' => $date, 'updated_at' => $date],
                    ['user_id' => $user->id, 'risk' => 'Low', 'market_cap' => '1B - 25B', 'color' => '#ffd8a8', 'created_at' => $date, 'updated_at' => $date],
                    ['user_id' => $user->id, 'risk' => 'Very Low', 'market_cap' => '>25B', 'color' => '#ffa8a8', 'created_at' => $date, 'updated_at' => $date],
                ];
                AssetMatrixConstraints::insert($data);
            }
        }
        return redirect()->back();
    }
    public function assign_portfolio_default()
    {
        $users = User::all('id');
        foreach ($users as $user) {
            if (Portfolio::where('user_id', $user->id)->count() == 0) {
                $portfolio = new Portfolio();
                $portfolio->user_id = $user->id;
                $portfolio->status = 1;
                $portfolio->save();
                AssetMatrixConstraints::where('user_id', $user->id)->update(['portfolio_id' => $portfolio->id]);
                Transaction::where('user_id', $user->id)->update(['portfolio_id' => $portfolio->id]);
            }
        }
        return redirect()->back();
    }


    public function change_allocation(Request $request)
    {
        $this->validate($request, [
            'portfolio_name' => 'required'
        ]);
        $data = $request->except('_token');
        $asset_matrix_data = $data['allocation_percentage'];
        $portfolio_name = $data['portfolio_name'];
        $portfolio_id = $data['portfolio_id'];
        $portfolio_to_update = Portfolio::find($portfolio_id);
        $portfolio_to_update->portfolio_name = $portfolio_name;
        $portfolio_to_update->save();
        $to_change_constraints = AssetMatrixConstraints::where('user_id', Auth::user()->id)->get();
        for ($i = 0; $i < count($to_change_constraints); $i++) {
            $to_change_constraints[$i]->update([
                "percentage_allocation" => $asset_matrix_data[$i]
            ]);
        }
        return redirect()->back();
    }
    public function all_transaction()
    {
        return view($this->_page . 'index', $this->_data);
    }
    public function getall_transactions()
    {
        $query = " Select t.units as units,t.purchase_price as purchase_price, t.investment_type as status, t.purchase_date as date,
        c.name as coin_name,u.name as username
        from transactions as t
        join coins as c on t.coin_id=c.id
        join users as u on t.user_id=u.id order by t.id desc";
        $transactions = DB::select($query);
        return response()->json(["data" => $transactions]);
    }
}
