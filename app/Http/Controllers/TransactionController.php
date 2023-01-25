<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExport;
use App\Imports\ImportTransaction;
use App\Models\AssetMatrixConstraints;
use App\Models\Coin;
use App\Models\Portfolio;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
            'portfolio_id' => 'required',
        ]);

        $data = $request->except('_token');
        $user = Auth::user();
        $selected_portfolio = Portfolio::where("user_id", $user->id)->where('id', $request->portfolio_id)->get('id');
        if ($data['coin_investment_type'] == 'sell') {
            $to_check_transaction = DB::select('CALL usp_get_current_transaction_coin_wise(' . $user->id . ',' . $data['coin_id'] . ',' . $selected_portfolio[0]->id . ')');

            if (!empty($to_check_transaction)) {
                $to_check_buy_total = isset($to_check_transaction[0]->buy_unit) ? $to_check_transaction[0]->buy_unit : 0;
                $to_check_sell_total = isset($to_check_transaction[0]->sell_unit) ? $to_check_transaction[0]->sell_unit : 0;
                $to_check_amt = $to_check_buy_total - $to_check_sell_total - $data['units'];
                if ($to_check_amt < 0) {
                    return redirect()->back()->with('fail', 'Information could not be added.');
                }
            } else {
                return redirect()->back()->with('fail', 'Information could not be added.');
            }
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->coin_id = $data['coin_id'];
        $transaction->symbol = $data['symbol'];
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
        $portfolio_id = $request->portfolio_id;
        $selected_portfolio = Portfolio::where("user_id", $user->id)->where('id', $portfolio_id)->get('id');
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

        $data = $request->except('_token');
        $asset_matrix_data = $data['allocation_percentage'];
        $portfolio_name = isset($data['portfolio_name']) ? $data['portfolio_name'] : '';
        $portfolio_id = $data['portfolio_id'];
        $portfolio_to_update = Portfolio::find($portfolio_id);
        $portfolio_to_update->portfolio_name = $portfolio_name;
        $portfolio_to_update->save();
        $to_change_constraints = AssetMatrixConstraints::where('user_id', Auth::user()->id)->where('portfolio_id', $portfolio_id)->get();
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
    public function getall_transactions(Request $request)
    {

        $transactions = DB::table('vw_all_transactions')->get();
        return response()->json(["data" => $transactions]);
    }
    public function excel_import_sample_download(Request $request)
    {
        $filename = "TransactionImportSamplefile.csv";
        return Excel::download(new ExcelExport, $filename);
    }
    public function excel_import_submit(Request $request)
    {
        $file = $request->file('file_name');
        $portfolio_id = $request->portfolio_id;
        $rows = Excel::toCollection(new ImportTransaction, $file);
        $datas = $rows[0];
        $valid_transaction = array();
        $invalid_transaction = array();
        for ($key = 1; $key < count($datas); $key++) {
            if ($datas[$key][2] > 0 && $datas[$key][3] > 0) {
                $coin_id =  $this->checkCoinInDatabase($datas[$key][0]);
                if (!empty($coin_id) && ($datas[$key][1] == "buy" || $datas[$key][1] == "sell")) {
                    $datas_array = array();
                    if (gettype($datas[$key][4]) == "string") {
                        $date = strtotime($datas[$key][4]);
                        $datas_array[5] =  date('Y-m-d', $date);
                    } elseif (gettype($datas[$key][4]) == "int" || gettype($datas[$key][4]) == "float") {
                        $datas_array[5] = $this->convertExcelTimetoCarbon($datas[$key][4]);
                    } else {
                        $datas_array[5] = '';
                    }
                    $datas_array[4] = $datas[$key][3];
                    if (gettype($datas[$key][3]) == "string") {
                        $datas_array[4] = floatVal(str_replace(",", "", $datas[$key][3]));
                    }
                    $datas_array[2] = $datas[$key][1];
                    if (gettype($datas[$key][2]) == "string") {
                        $datas_array[3] = floatVal(str_replace(",", "", $datas[$key][2]));
                    }
                    $datas_array[0] = $coin_id->coin_id;
                    $datas_array[1] = $coin_id->id;
                    $datas_array[3] = $datas[$key][2];
                    array_push($valid_transaction, $datas_array);
                } else {
                    if (gettype($datas[$key][4]) == "string") {
                        $date = strtotime($datas[$key][4]);
                        $datas[$key][4] =  date('Y-m-d', $date);
                    } elseif (gettype($datas[$key][4]) == "int" || gettype($datas[$key][4]) == "float") {
                        $datas[$key][4] = $this->convertExcelTimetoCarbon($datas[$key][4]);
                    } else {
                        $datas[$key][4] = '';
                    }
                    array_push($invalid_transaction, $datas[$key]);
                }
            }
        }
        return view('pages.dashboard-content.transaction_excel_result_display', compact('valid_transaction', 'invalid_transaction', 'portfolio_id'))->with('delete-success', "Transaction is imported");;
    }
    public function displayExcelData()
    {
        return view('pages.dashboard-content.transaction_excel_result_display');
    }
    public function convertExcelTimetoCarbon($time)
    {
        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($time))->format('Y-m-d');
    }
    public function final_excel_report_submit(Request $request)
    {

        $user = Auth::user();
        $data = $request->except('_method', '_token');
        try {
            DB::transaction(function () use ($data, $user) {
                for ($i = 0; $i < count($data['coin_id']); $i++) {
                    $transaction = new Transaction();
                    $transaction->portfolio_id = $data['portfolio_id'];
                    $transaction->symbol = $data['symbol'][$i];
                    $transaction->coin_id = $data['coin_id'][$i];
                    $transaction->purchase_price_per_unit = $data['price_per_unit'][$i];
                    $transaction->units = $data['units'][$i];
                    $transaction->purchase_date = $data['purchase_date'][$i];
                    $transaction->investment_type = $data['investment_type'][$i];
                    $transaction->purchase_price = $data['price_per_unit'][$i] * $data['units'][$i];
                    $transaction->user_id = $user->id;
                    $transaction->save();
                }
            });
            return redirect()->route('portfolio.specific', $data['portfolio_id'])->with('success', 'New Transactions from excel file added');
        } catch (\Throwable $th) {
            return redirect()->route('portfolio.specific', $data['portfolio_id'])->with('fail', 'Error in Submitting Transaction');
        }
    }
    public function checkCoinInDatabase($coin_symbol)
    {
        $coin = strtolower($coin_symbol);
        return Coin::where('coin_id', '=', $coin)
            ->orWhere('symbol', '=', $coin_symbol)
            ->orWhere('name', '=', $coin_symbol)
            ->select(['coin_id', 'id'])
            ->first();
    }
    public function loadWallet(Request $request)
    {
        $wallet_address = $request->wallet_address;
        return view('pages.wallet.dashboard', compact('wallet_address'));
    }

    public function loadWalletCalculations(Request $request)
    {
        $base_url = "https://api.etherscan.io/api?module=account";
        $action = "&action=txlist";
        $wallet_address = "&address=" . $request->wallet_address;
        $sort_details = "&sort=asc";
        $api_key = "&apikey=FY5RF1IUVNPFKSY4FV9MBAJ6NDAJ5SRTDA";
        $url = $base_url . $action . $wallet_address . $sort_details . $api_key;
        // Lists the successful transaction's block number
        $results = $this->establish_curl($url);
        if ($results['status'] != 1) {
            return redirect()->back()->with('fail', "Couldn't load wallet. Please try again later.");
        }
        $success_block_number = array_column(array_filter($results['result'], function ($result) {
            return $result['isError'] == '0' && $result['txreceipt_status'] == '1';
        }), 'blockNumber');

        // Lists the transctions with coin details
        $action = "&action=tokentx";
        $url = $base_url . $action . $wallet_address . $sort_details . $api_key;
        $results = $this->establish_curl($url);
        if ($results['status'] != 1) {
            return redirect()->back()->with('fail', "Couldn't load wallet. Please try again later.");
        }
        $coins_available = array();
        $buy_transactions = array();
        $sell_transactions = array();
        $portfolio = array();
        $wallet_address = strtolower($request->wallet_address);
        $actual_results = array_filter($results['result'], function ($result) use ($success_block_number) {
            return in_array($result['blockNumber'], $success_block_number) && $result['value'] !== '0';
        });

        // Group actual results by contract address
        $grouped_results = array();
        foreach ($actual_results as $result) {
            $grouped_results[$result['contractAddress']][] = $result;
        }
        foreach ($grouped_results as $contract_address => $results) {
            // Get the max and min timestamp of the successful transactions
            $max_timestamp = strtotime("+1 hour", max(array_column($results, 'timeStamp')));
            $min_timestamp = strtotime("-1 hour", min(array_column($results, 'timeStamp')));
            $grouped_results[$contract_address]['buy_unit'] = '0';
            $grouped_results[$contract_address]['sell_unit'] = '0';
            $grouped_results[$contract_address]['buy_amount'] = '0';
            // Use the max and min timestamp to make the API call
            $url = "https://api.coingecko.com/api/v3/coins/ethereum/contract/" . $contract_address . "/market_chart/range?vs_currency=usd&from=" . $min_timestamp . "&to=" . $max_timestamp . "&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
            $price_response = $this->establish_curl($url);
            if (isset($price_response['prices']) && !empty($price_response['prices'])) {
                // Process the results for this contract address
                foreach ($results as $result) {
                    $transaction_timestamp = $result['timeStamp'];
                    $closest_timestamp = '';
                    $closest_diff = '';
                    foreach ($price_response['prices'] as $key => $price) {
                        $api_timestamp = $price[0];
                        $diff = abs($api_timestamp - $transaction_timestamp);
                        if ($closest_diff === '' || $diff < $closest_diff) {
                            $closest_diff = $diff;
                            $closest_timestamp = $key;
                        }
                    }
                    $units = $result['value'] / 1000000000000000000;
                    $purchase_price = $units * $price_response['prices'][$closest_timestamp][1];
                    if ($result['from'] == $wallet_address) {
                        // sell transaction
                        array_push($sell_transactions, (object)[
                            'tokenName' => $result['tokenName'],
                            'tokenSymbol' => $result['tokenSymbol'],
                            'units' => $units,
                            'purchase_price' => $purchase_price,
                            'contract_address' => $contract_address
                        ]);
                        $grouped_results[$contract_address]['sell_unit'] = floatval($grouped_results[$contract_address]['sell_unit']) + floatval($units);
                    } elseif ($result['to'] == $wallet_address) {
                        // buy transaction
                        array_push($buy_transactions, (object)[
                            'tokenName' => $result['tokenName'],
                            'tokenSymbol' => $result['tokenSymbol'],
                            'units' => $units,
                            'purchase_price' => $purchase_price,
                            'contract_address' => $contract_address
                        ]);
                        $grouped_results[$contract_address]['buy_unit'] = floatval($grouped_results[$contract_address]['buy_unit']) + floatval($units);
                        $grouped_results[$contract_address]['buy_amount'] = floatval($grouped_results[$contract_address]['buy_amount']) + floatval($purchase_price);
                    }
                }
            }
        }
        foreach ($grouped_results as $contract_address => $results) {
            $token_name = $results[0]['tokenName'];
            $token_symbol = $results[0]['tokenSymbol'];
            array_push($coins_available, (object) [
                'contract_address' => $contract_address,
                'tokenName' => $token_name,
                'tokenSymbol' => $token_symbol,
                'buy_unit' => $results['buy_unit'],
                'sell_unit' => $results['sell_unit'],
                'buy_amount' => $results['buy_amount']
            ]);
        }
        $total_worth = array();
        $current_transactions = array();

        foreach ($coins_available as $coin) {
            $total_worth[$coin->contract_address] = $coin->buy_amount;
        }

        foreach ($buy_transactions as $b_t) {
            $current_transactions[$b_t->contract_address] = [
                'units' => $b_t->units,
                'purchase_price' => $b_t->purchase_price,
                'debited_units' => 0,
                'profit_loss' => 0,
            ];
        }

        if (!empty($sell_transactions)) {
            foreach ($sell_transactions as $s_t) {
                $coin_name = $s_t->contract_address;
                $sell_units = $s_t->units;
                $sell_unit_price = $s_t->purchase_price / $s_t->units;

                if (isset($current_transactions[$coin_name])) {
                    $current_transaction = $current_transactions[$coin_name];
                    $purchase_unit_price = $current_transaction['purchase_price'] / $current_transaction['units'];
                    $profit_loss_rate = $sell_unit_price - $purchase_unit_price;
                    $total_units = $current_transaction['units'];
                    $total_debited_units = $current_transaction['debited_units'];
                    $slot_units_available = $total_units - $total_debited_units;
                    $profit_earned = $current_transaction['profit_loss'];

                    if ($slot_units_available > 0) {
                        if ($slot_units_available >= $sell_units) {
                            $current_transactions[$coin_name]['debited_units'] = $total_debited_units + $sell_units;
                            $current_transactions[$coin_name]['profit_loss'] = $profit_earned + $profit_loss_rate * $sell_units;

                            $total_worth[$coin_name] = $total_worth[$coin_name] - $sell_units * $purchase_unit_price;
                            break;
                        } else {
                            $current_transactions[$coin_name]['debited_units'] = $total_debited_units + $slot_units_available;
                            $current_transactions[$coin_name]['profit_loss'] = $profit_earned + $profit_loss_rate * $slot_units_available;
                            $total_worth[$coin_name] = $total_worth[$coin_name] - $slot_units_available * $purchase_unit_price;
                            $sell_units -= $slot_units_available;
                        }
                    }
                }
            }
        }
        $worth = array();
        foreach ($coins_available as $coins) {
            $total_current_invested = $total_worth[$coins->contract_address];
            $total_buy = $coins->buy_unit ? $coins->buy_unit : 0;
            $total_sell = $coins->sell_unit ? $coins->sell_unit : 0;
            $remaining_coins = $total_buy - $total_sell;
            $contract_address = "$coins->contract_address";
            $url = "https://api.coingecko.com/api/v3/coins/ethereum/contract/" . $contract_address . "?x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
            $current_prices_list_details_from_server = $this->establish_curl($url);
            $current_market_capital = isset($current_prices_list_details_from_server['market_data']['market_cap']['usd']) ? $current_prices_list_details_from_server['market_data']['market_cap']['usd'] : 0;
            $current_price = isset($current_prices_list_details_from_server['market_data']['current_price']['usd']) ? $current_prices_list_details_from_server['market_data']['current_price']['usd'] : 0;
            $price_change_percentage_24h = isset($current_prices_list_details_from_server['market_data']['price_change_percentage_24h']) ? $current_prices_list_details_from_server['market_data']['price_change_percentage_24h'] : 0;
            $price_change_percentage_7d = isset($current_prices_list_details_from_server['market_data']['price_change_percentage_7d']) ? $current_prices_list_details_from_server['market_data']['price_change_percentage_7d'] : 0;
            $all_time_high_price_percentage = isset($current_prices_list_details_from_server['market_data']['ath_change_percentage']['usd']) ? $current_prices_list_details_from_server['market_data']['ath_change_percentage']['usd'] : 0;
            $todaysWorth = $remaining_coins * $current_price;
            $return = $total_current_invested == 0 ? 0 : round(($todaysWorth - $total_current_invested) / $total_current_invested, 2) * 100;
            $worth = array_merge(
                $worth,
                array($coins->tokenName =>
                array(
                    "buy_unit" => $total_buy,
                    "sell_unit" => $total_sell,
                    "usd_market_cap" => round($current_market_capital, 2),
                    "current_usd" => round($current_price, 2),
                    "return" => $return,
                    "24hr" => round($price_change_percentage_24h, 2),
                    "7d" => round($price_change_percentage_7d, 2),
                    "ATH" => round($all_time_high_price_percentage, 2)
                ))
            );
        }
        $this->_data['worth'] = $worth;
        return view("pages." . 'wallet.' . 'coin_worth', $this->_data);
    }
    public function establish_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
