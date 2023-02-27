<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExport;
use App\Imports\ImportTransaction;
use App\Models\AssetMatrixConstraints;
use App\Models\Coin;
use App\Models\Portfolio;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class TransactionController extends Controller
{
    private $_app = "";
    private $_page = "pages.transaction.";
    private $_data = [];
    private $coingeckoBaseUrl = "https://pro-api.coingecko.com/api/v3/coins/ethereum";
    private $coingecko_pro_key = "&x_cg_pro_api_key=CG-N6JsBYNKHnYSjbU7NUyzzYhq";
    private $etherscanBaseUrl = "https://api.etherscan.io/api";
    private $etherscan_pro_key = "&apikey=FY5RF1IUVNPFKSY4FV9MBAJ6NDAJ5SRTDA";
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
        $secret_key = (new Transaction)->secret_key;
        $data = $request->except('_token');
        $user = Auth::user();
        $selected_portfolio = Portfolio::where("user_id", $user->id)->where('id', $request->portfolio_id)->get('id');
        if ($data['coin_investment_type'] == 'sell') {
            $to_check_transaction = DB::select('CALL usp_get_current_transaction_coin_wise(' . $user->id . ',' . $data['coin_id'] . ',' . $selected_portfolio[0]->id . ',' . $secret_key . ')');

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
        $secret_key = (new Transaction)->secret_key;
        $selected_portfolio = Portfolio::where("user_id", $user->id)->where('id', $portfolio_id)->get('id');
        if ($investment_type == 'sell') {
            $to_check_transaction = DB::select('CALL usp_get_current_transaction_coin_wise(' . $user->id . ',' . $given_coin_id . ',' . $selected_portfolio[0]->id . ',' . $secret_key . ')');
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
    // public function profit_calculation()
    // {
    //     $user = Auth::user();
    //     $coins_available = DB::select('select distinct name from vw_buy_transactions where user_id = ?', [$user->id]);
    //     $buy_transactions = DB::select('select units,name,purchase_price from vw_buy_transactions where user_id = ? order by name asc', [$user->id]);
    //     $sell_transactions = DB::select('select units,name,purchase_price from vw_sell_transactions where user_id = ? order by name asc', [$user->id]);
    //     // return([$sell_transactions]);
    //     $total_profit = array();


    //     $current_transactions = array();
    //     foreach ($coins_available as $coins) {
    //         array_push($total_profit, array($coins->name, 0));
    //     }


    //     foreach ($buy_transactions as $b_t) {
    //         array_push($current_transactions, array($b_t->name, $b_t->units, $b_t->purchase_price, 0, 0));
    //     }


    //     $total_sell_units = array();
    //     foreach ($sell_transactions as $s_t) {
    //         array_push($total_sell_units, array($s_t->name, $s_t->units, $s_t->purchase_price));
    //     }
    //     foreach ($total_sell_units as $sell_unit) {
    //         $total_sell_unit = $sell_unit[1];
    //         $sell_unit_price = $sell_unit[2] / $sell_unit[1];
    //         $sell_unit_coin_name = $sell_unit[0];

    //         if ($total_sell_unit > 0) {
    //             for ($i = 0; $i < count($current_transactions); $i++) {
    //                 if ($sell_unit_coin_name == $current_transactions[$i][0]) {
    //                     $current_transaction = $current_transactions[$i];
    //                     $purchase_unit_price = $current_transaction[2] / $current_transaction[1];
    //                     $profit_loss_rate = $sell_unit_price - $purchase_unit_price;
    //                     $total_units = $current_transaction[1];
    //                     $total_debited_units = $current_transaction[3];
    //                     $slot_units_available = $total_units - $total_debited_units;
    //                     $profit_earned = $current_transaction[4];
    //                     if ($slot_units_available > 0) {
    //                         if ($slot_units_available >= $total_sell_unit) {
    //                             if ($total_sell_unit > 0) {
    //                                 $current_transactions[$i][3] = $total_debited_units + $total_sell_unit;
    //                                 $current_transactions[$i][4] = $profit_earned + $profit_loss_rate * $total_sell_unit;
    //                                 $total_sell_unit = $total_sell_unit - $total_debited_units;
    //                                 break;
    //                             }
    //                         } elseif ($slot_units_available < $total_sell_unit) {
    //                             if ($total_sell_unit > 0) {
    //                                 $current_transactions[$i][3] = $total_debited_units + $slot_units_available;
    //                                 $current_transactions[$i][4] = $profit_earned + $profit_loss_rate * $slot_units_available;
    //                                 $total_sell_unit = $total_sell_unit - $slot_units_available;
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     // return ([$current_transactions]);
    //     for ($i = 0; $i < count($total_profit); $i++) {
    //         $profit = $total_profit[$i];
    //         foreach ($current_transactions as $ct) {
    //             if ($profit[0] == $ct[0]) {
    //                 $total_profit[$i][1] = $total_profit[$i][1] + $ct[4];
    //             }
    //         }
    //     }
    //     return response()->json(["success" => true, "data" => $total_profit]);
    // }


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
        $transactions = Transaction::join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->join('users', 'transactions.user_id', '=', 'coins.id')
            ->select(DB::raw('
            transactions.units as units,
              transactions.purchase_price as purchase_price,
              transactions.investment_type as status,
              transactions.purchase_date as date,
              coins.name as coin_name,
              users.name as username
            '))
            ->get();
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
    public function checkAndSaveWalletAddress($portfolio_id, $wallet_address)
    {
        $wallet_address_encrypted = (new Wallet)->encryptAttribute($wallet_address);
        $wallet = Wallet::where('portfolio_id', $portfolio_id)->where('wallet_address', $wallet_address_encrypted)->first();
        if (!isset($wallet)) {
            Wallet::create([
                'portfolio_id' => $portfolio_id,
                'wallet_address' => $wallet_address
            ]);
        }
    }

    public function loadWallet(Request $request)
    {
        $user = Auth::user();
        $transaction_count = Transaction::where('user_id', $user->id)->where('portfolio_id', $request->portfolio_id)->first();
        $all_address = array_map('strtolower', $request->wallet_address);
        $final_address = array_values(array_unique($all_address));
        if (isset($transaction_count)) {
            $portfolio = new Portfolio();
            $portfolio->user_id = Auth::id();
            $portfolio->save();
            (new AuthController)->create_asset_matrix($user, $portfolio);
            foreach ($final_address as $wallet_address) {
                Wallet::create([
                    'portfolio_id' => $portfolio->id,
                    'wallet_address' => $wallet_address
                ]);
            }
            return redirect()->route('portfolio.specific', $portfolio->id);
        }
        $portfolio = Portfolio::where('user_id', Auth::id())->where('id', $request->portfolio_id)->first();
        if ($portfolio) {
            foreach ($final_address as $wallet_address) {
                $this->checkAndSaveWalletAddress($portfolio->id, $wallet_address);
            }
            // Portfolio::find($request->portfolio_id)->update(['wallet_address' => $encoded_wallet_address]);
        }
        return redirect()->back();
    }

    public function loadWalletCalculations(Request $request, $portfolio_id)
    {
        if (Auth::user()) {
            $all_wallet_address = Wallet::where('portfolio_id', $portfolio_id)->pluck('wallet_address');
            $this->_data['all_wallet_address'] = $all_wallet_address;
            $this->_data['portfolio_id'] = $portfolio_id;
        } else {
            $wallet_address = explode(',', $request->wallet_address);
            $all_address = array_map('strtolower', $wallet_address);
            $all_wallet_address = array_values(array_unique($all_address));
            $this->_data['all_wallet_address'] = $all_wallet_address;
        }

        $invalid_contract_address = json_decode(Redis::get('invalid_coins'));
        if (!isset($invalid_contract_address)) {
            $invalid_contract_address = [];
        }
        $worths = [];
        $invalid_wallet_address = [];
        $count = 0;
        $base_url = $this->etherscanBaseUrl . "?module=account&action=tokentx&sort=asc" . $this->etherscan_pro_key;
        if (isset($all_wallet_address)) {
            foreach ($all_wallet_address as $address) {
                $actual_results = [];
                $url = $base_url . "&address=" . $address;
                $results = $this->establish_curl($url);
                if (isset($results) && $results['status'] == 1) {
                    $actual_results = array_filter($results['result'], function ($result) use ($invalid_contract_address) {
                        return $result['value'] > 0 && !in_array($result['contractAddress'], $invalid_contract_address);
                    });
                    // $actual_results = array_merge($actual_results, $filtered_results);

                    $coins_available = [];
                    $buy_transactions = [];
                    $sell_transactions = [];
                    // $actual_results = array_merge($actual_results, $success_block_number);

                    // Group actual results by contract address
                    $grouped_results = [];
                    $missing_cache = [];
                    $lookup_table = [0, 1, 2, 3, 6, 12, 13, 24, 25, 48, 49, 71, 72];

                    foreach ($actual_results as $result) {
                        if ($result['contractAddress'] == '') {
                            $result['contractAddress'] = 'ethereum';
                            $result['tokenName'] = 'Ethereum';
                            $result['tokenSymbol'] = 'eth';
                        }
                        $grouped_results[$result['contractAddress']][] = $result;
                        $contract_address = $result['contractAddress'];
                        $unix_timestamp = $result['timeStamp'];
                        $new_unix_timestamp = mktime(date("H", $unix_timestamp), 0, 0, date("n", $unix_timestamp), date("j", $unix_timestamp), date("Y", $unix_timestamp));
                        // if ($contract_address == '0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48') {
                        //     $new_unix_timestamp = mktime(0, 0, 0, date("n", $unix_timestamp), date("j", $unix_timestamp), date("Y", $unix_timestamp));
                        // }
                        $cache_key = $contract_address . '_' . $new_unix_timestamp;
                        $price = Redis::get($cache_key);
                        if (!isset($price)) {
                            $cache_keys = [];
                            // foreach ($lookup_table as $i) {
                            for ($i = 0; $i < 48; $i++) {
                                // Generate cache key based on current time plus $i hours
                                $added_unix_timestamp = strtotime("+$i hour", $unix_timestamp);
                                $new_unix_timestamp = mktime(date("H", $added_unix_timestamp), 0, 0, date("n", $added_unix_timestamp), date("j", $added_unix_timestamp), date("Y", $added_unix_timestamp));
                                $cache_keys[] = $contract_address . '_' . $new_unix_timestamp;
                            }

                            // Retrieve values for all cache keys in one Redis call
                            $values = Redis::mget($cache_keys);
                            foreach ($values as $value) {
                                if (isset($value)) {
                                    $price = $value;
                                    break;
                                }
                            }

                            if (!isset($price)) {
                                // Price not found, add to missing cache
                                $missing_cache[$result['contractAddress']][] = $result;
                            }
                        }
                    }
                    $api_rate_limit_flag = 0;
                    if (!empty($missing_cache)) {
                        // dd($missing_cache);
                        foreach ($missing_cache as $contract_address => $results) {
                            $max_timestamp = strtotime("+3 day", max(array_column($results, 'timeStamp')));
                            $min_timestamp = strtotime("-2 day", min(array_column($results, 'timeStamp')));

                            // $max_timestamp = strtotime("+2 hour", max(array_column($results, 'timeStamp')));
                            // $min_timestamp = strtotime("-2 hour", min(array_column($results, 'timeStamp')));
                            // if ($contract_address == '0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48') {
                            //     $max_timestamp = strtotime("+2 day", max(array_column($results, 'timeStamp')));
                            //     $min_timestamp = strtotime("-2 day", min(array_column($results, 'timeStamp')));
                            // }
                            $api_rate_limit_flag = $this->sync_cache($contract_address, $max_timestamp, $min_timestamp);
                            if ($api_rate_limit_flag == 1) {
                                break;
                            }
                        }
                    }
                    foreach ($grouped_results as $contract_address => $results) {
                        $grouped_results[$contract_address]['buy_unit'] = '0';
                        $grouped_results[$contract_address]['sell_unit'] = '0';
                        $grouped_results[$contract_address]['buy_amount'] = '0';
                        // Process the results for this contract address
                        foreach ($results as $result) {
                            $unix_timestamp = $result['timeStamp'];
                            $new_unix_timestamp = mktime(date("H", $unix_timestamp), 0, 0, date("n", $unix_timestamp), date("j", $unix_timestamp), date("Y", $unix_timestamp));
                            // if ($contract_address == '0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48') {
                            //     $new_unix_timestamp = mktime(0, 0, 0, date("n", $unix_timestamp), date("j", $unix_timestamp), date("Y", $unix_timestamp));
                            // }

                            $cache_key = $contract_address . '_' . $new_unix_timestamp;
                            $redis_price = Redis::get($cache_key);

                            if (!isset($redis_price)) {
                                $cache_keys = [];
                                // foreach ($lookup_table as $i) {
                                for ($i = 0; $i < 48; $i++) {
                                    // Generate cache key based on current time plus $i hours
                                    $added_unix_timestamp = strtotime("+$i hour", $unix_timestamp);
                                    $new_unix_timestamp = mktime(date("H", $added_unix_timestamp), 0, 0, date("n", $added_unix_timestamp), date("j", $added_unix_timestamp), date("Y", $added_unix_timestamp));
                                    $cache_keys[] = $contract_address . '_' . $new_unix_timestamp;
                                }

                                // Retrieve values for all cache keys in one Redis call
                                $values = Redis::mget($cache_keys);
                                // dd($values);
                                foreach ($values as $value) {
                                    if (isset($value)) {
                                        $redis_price = $value;
                                        break;
                                    }
                                }
                            }
                            // if ($contract_address == "0x7a58c0be72be218b41c608b7fe7c5bb630736c71") {
                            //     dd($price, $contract_address, $result);
                            // }
                            $price = isset($redis_price) ? $redis_price : 0;
                            $units = $result['value'] / 10 ** $result['tokenDecimal'];
                            // print_r($cache_key . "   " . $redis_price . "    " . $units . "<br>");
                            $purchase_price = $units * $price;
                            // dd($all_wallet_address,$result);
                            if (strtolower($result['from']) == $address) {
                                // sell transaction
                                array_push($sell_transactions, (object)[
                                    'tokenName' => $result['tokenName'],
                                    'tokenSymbol' => $result['tokenSymbol'],
                                    'units' => $units,
                                    'purchase_price' => $purchase_price,
                                    'contract_address' => $contract_address,
                                    'timeStamp' => $result['timeStamp']
                                ]);
                                $grouped_results[$contract_address]['sell_unit'] = floatval($grouped_results[$contract_address]['sell_unit']) + floatval($units);
                            } elseif (strtolower($result['to']) == $address) {
                                // buy transaction
                                array_push($buy_transactions, (object)[
                                    'tokenName' => $result['tokenName'],
                                    'tokenSymbol' => $result['tokenSymbol'],
                                    'units' => $units,
                                    'purchase_price' => $purchase_price,
                                    'contract_address' => $contract_address,
                                    'timeStamp' => $result['timeStamp']
                                ]);
                                $grouped_results[$contract_address]['buy_unit'] = floatval($grouped_results[$contract_address]['buy_unit']) + floatval($units);
                                $grouped_results[$contract_address]['buy_amount'] = floatval($grouped_results[$contract_address]['buy_amount']) + floatval($purchase_price);
                            }
                        }
                    }
                    // dd($buy_transactions, $sell_transactions);
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

                    $total_worth = [];
                    $current_transactions = [];

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
                    usort($sell_transactions, function ($a, $b) {
                        return $a->timeStamp > $b->timeStamp;
                    });
                    usort($buy_transactions, function ($a, $b) {
                        return $a->timeStamp > $b->timeStamp;
                    });
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
                    $worth = [];

                    array_push($coins_available, (object) [
                        'contract_address' => 'ethereum',
                        'tokenName' => 'Ethereum',
                        'tokenSymbol' => 'eth',
                        'buy_unit' => $this->calc_ether_value($address),
                        'sell_unit' => 0,
                        'buy_amount' => 0
                    ]);
                    foreach ($coins_available as $coins) {
                        $contract_address = $coins->contract_address;
                        $unix_timestamp = time();
                        $new_unix_timestamp = mktime(date("H", $unix_timestamp), 0, 0, date("n", $unix_timestamp), date("j", $unix_timestamp), date("Y", $unix_timestamp));
                        $cache_key = $contract_address . '_' . $new_unix_timestamp;
                        $current_value =  Redis::get($cache_key);
                        if (!isset($current_value)) {
                            $api_rate_limit_flag = $this->sync_current_price_coin($contract_address, $cache_key);
                            if ($api_rate_limit_flag == 1) {
                                break;
                            }
                        }
                        if ($coins->contract_address !== 'ethereum') {
                            $total_current_invested = $total_worth[$coins->contract_address];
                        }
                        $total_buy = $coins->buy_unit ? $coins->buy_unit : 0;
                        $total_sell = $coins->sell_unit ? $coins->sell_unit : 0;
                        $remaining_coins = $total_buy - $total_sell;
                        $current_market_capital = 0;
                        $current_price = 0;
                        $price_change_percentage_24h = 0;
                        $price_change_percentage_7d = 0;
                        $all_time_high_price_percentage = 0;
                        $cache_data = Redis::get($cache_key);
                        if (isset($cache_data)) {
                            $current_prices_list_details_from_server = json_decode($cache_data);
                            $current_market_capital = $current_prices_list_details_from_server->current_market_capital;
                            $current_price = $current_prices_list_details_from_server->current_price;
                            $price_change_percentage_24h = $current_prices_list_details_from_server->price_change_percentage_24h;
                            $price_change_percentage_7d = $current_prices_list_details_from_server->price_change_percentage_7d;
                            $all_time_high_price_percentage = $current_prices_list_details_from_server->all_time_high_price_percentage;

                            $todaysWorth =  $remaining_coins * $current_price;
                            if ($coins->contract_address == 'ethereum') {
                                $total_current_invested = $todaysWorth;
                            }
                            $return = $total_current_invested == 0 ? 0 : round(($todaysWorth - $total_current_invested) / $total_current_invested, 2) * 100;
                            $worth = array_merge(
                                $worth,
                                array($coins->tokenName =>
                                array(
                                    "buy_unit" => $total_buy,
                                    "sell_unit" => $total_sell,
                                    "usd_market_cap" => round($current_market_capital, 2),
                                    "current_usd" => $current_price,
                                    "return" => $return,
                                    "24hr" => round($price_change_percentage_24h, 2),
                                    "7d" => round($price_change_percentage_7d, 2),
                                    "ATH" => round($all_time_high_price_percentage, 2),
                                    "worth" => $todaysWorth,
                                    "total_current_invested" => $total_current_invested
                                ))
                            );
                        }
                    }
                    $worths[$count++] = $worth;
                } else {
                    $invalid_wallet_address[] = $address;
                }
            }
            $this->_data['invalid_wallet_address'] = implode(', ', $invalid_wallet_address);
            if (count($all_wallet_address) == count($invalid_wallet_address)) {
                return view("pages." . 'wallet.' . 'coin_worth', $this->_data);
            }
            $keys = $this->getUniqueKeys($worths);
            $datas = $this->group_result($worths, $keys);
            $worth = [];
            $total_worth = 0;
            foreach ($datas as $key => $data) {
                $result = $this->calculate_combined_return($data);
                if ($result['worth'] > 50) {
                    if ($key !== 'Ethereum') {
                        $total_worth += $result['worth'];
                    }
                    $worth[$key] = $result;
                }
            }

            $this->_data['api_rate_limit_flag'] = $api_rate_limit_flag;
            $this->_data['worth'] = $worth;
            $this->_data['total_worth'] = round($total_worth, 2);
        }
        return view("pages." . 'wallet.' . 'coin_worth', $this->_data);
    }

    public function group_result($worths, $keys)
    {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = [];
            foreach ($worths as $worth) {
                if (array_key_exists($key, $worth)) {
                    $data[$key][] = $worth[$key];
                }
            }
        }
        return $data;
    }

    public function getUniqueKeys($array)
    {
        // Use array_reduce to merge all the keys from each inner array
        $uniqueKeys = array_reduce($array, function ($carry, $innerArray) {
            return array_merge($carry, array_keys($innerArray));
        }, []);

        // Use array_unique to get only the unique keys
        $uniqueKeys = array_unique($uniqueKeys);
        return $uniqueKeys;
    }
    public function calculate_combined_return($investments)
    {
        // Arrays to store todaysWorth, return, and total_current_invested for each investment
        $todaysWorths = [];
        $total_current_invested = [];

        // Loop through investments and calculate todaysWorth, return, and total_current_invested for each
        foreach ($investments as $investment) {
            $todaysWorths[] = $investment["worth"];
            $total_current_invested[] = $investment["total_current_invested"];
        }

        // Calculate total cost and current value of all investments
        $total_cost_of_investment = array_sum($total_current_invested);
        $current_value_of_investment = array_sum($todaysWorths);

        // Check if total cost of investment is zero
        if ($total_cost_of_investment == 0) {
            $total_return = 0;
        } else {
            // Calculate total return on all investments
            $total_return = (($current_value_of_investment - $total_cost_of_investment) / $total_cost_of_investment) * 100;
        }
        return array(
            "usd_market_cap" => $investments[0]["usd_market_cap"],
            "current_usd" => $investments[0]["current_usd"],
            "return" => $total_return,
            "24hr" => $investments[0]["24hr"],
            "7d" => $investments[0]["7d"],
            "ATH" => $investments[0]["ATH"],
            "worth" => $current_value_of_investment
        );
    }
    public function calc_ether_value($wallet_address)
    {
        $url = $this->etherscanBaseUrl . "?module=account&action=balance&address=" . $wallet_address . "&tag=latest" . $this->etherscan_pro_key;
        $response = $this->establish_curl($url);
        $total_ether = 0;
        if ($response['status'] == '1') {
            $total_ether = $response['result'];
        }
        return ($total_ether / 1000000000000000000);
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

    // Use the max and min timestamp and contract address to make the API call
    public function sync_cache($contract_address, $max_timestamp, $min_timestamp)
    {
        $invalid_contract_address = json_decode(Redis::get('invalid_coins'));
        if (!isset($invalid_contract_address)) {
            Redis::set("invalid_coins", json_encode([]));
            $invalid_contract_address = [];
        }
        if (!in_array($contract_address, $invalid_contract_address)) {
            $url = $this->coingeckoBaseUrl . "/contract/" . $contract_address . "/market_chart/range?vs_currency=usd&from=" . $min_timestamp . "&to=" . $max_timestamp . $this->coingecko_pro_key;
            if ($contract_address == 'ethereum') {
                $url = $this->coingeckoBaseUrl . "/market_chart/range?vs_currency=usd&from=" . $min_timestamp . "&to=" . $max_timestamp . $this->coingecko_pro_key;
            }
            $price_response = $this->establish_curl($url);
            // Log::info($url);
            // Log::info("Fetching coingecko for Syncing cache");
            if (!isset($price_response['prices']) || empty($price_response['prices'])) {

                // Log::error("Error fetching" . Carbon::now());
                // Log::error($price_response);
                if (isset($price_response['error'])) {
                    if ($price_response['error'] == 'coin not found') {
                        array_push($invalid_contract_address, $contract_address);
                        Redis::set("invalid_coins", json_encode($invalid_contract_address));
                        return 0;
                    }
                }
                if (isset($price_response['status']['error_code'])) {
                    if ($price_response['status']['error_code'] == 429) {
                        return 1;
                    }
                }
            }
            if (isset($price_response['prices']) && !empty($price_response['prices'])) {
                // Process the results for this contract address
                foreach ($price_response['prices'] as $timestamp_price) {
                    $unix_timestamp = $timestamp_price[0];
                    $unix_timestamp = floor($unix_timestamp / 1000);
                    $new_unix_timestamp = mktime(date("H", $unix_timestamp), 0, 0, date("n", $unix_timestamp), date("j", $unix_timestamp), date("Y", $unix_timestamp));
                    $cache_key = $contract_address . '_' . $new_unix_timestamp;
                    // Log::info("Adding to cache");
                    $price = Redis::get($cache_key);
                    // Log::info("cache_key :" . $cache_key);
                    // Log::info("price :" . $price);
                    if (!isset($price) && $timestamp_price[1] > 0) {
                        // Log::info("price :" . $timestamp_price[1]);
                        Redis::set($cache_key, $timestamp_price[1]);
                    }
                }
                return 0;
            }
        }
    }
    public function sync_current_price_coin($contract_address, $cache_key)
    {
        $invalid_contract_address = json_decode(Redis::get('invalid_coins'));
        if (!isset($invalid_contract_address)) {
            Redis::set("invalid_coins", json_encode([]));
            $invalid_contract_address = [];
        }

        if (!in_array($contract_address, $invalid_contract_address)) {
            $url = $this->coingeckoBaseUrl . "/contract/" . $contract_address . "?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false" . $this->coingecko_pro_key;
            if ($contract_address == 'ethereum') {
                $url = $this->coingeckoBaseUrl . "?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false" . $this->coingecko_pro_key;
            }
            // Log::info($url);
            $current_prices_list_details_from_server = $this->establish_curl($url);
            if (isset($current_prices_list_details_from_server['market_data']['market_cap']['usd'])) {
                $current_market_capital = $current_prices_list_details_from_server['market_data']['market_cap']['usd'];
                $current_price = $current_prices_list_details_from_server['market_data']['current_price']['usd'];
                $price_change_percentage_24h = $current_prices_list_details_from_server['market_data']['price_change_percentage_24h'];
                $price_change_percentage_7d = $current_prices_list_details_from_server['market_data']['price_change_percentage_7d'];
                $all_time_high_price_percentage =  $current_prices_list_details_from_server['market_data']['ath_change_percentage']['usd'];
                Redis::set($cache_key, json_encode([
                    'current_market_capital' => $current_market_capital,
                    'current_price' => $current_price,
                    'price_change_percentage_24h' => $price_change_percentage_24h,
                    'price_change_percentage_7d' => $price_change_percentage_7d,
                    'all_time_high_price_percentage' => $all_time_high_price_percentage
                ]), 'EX', 3000);
                return 0;
            } else {
                if (isset($current_prices_list_details_from_server['error'])) {
                    if ($current_prices_list_details_from_server['error'] == 'coin not found') {
                        array_push($invalid_contract_address, $contract_address);
                        Redis::set("invalid_coins", json_encode($invalid_contract_address));
                        return 0;
                    }

                    // Log::info("Fetching coingecko for Current price");
                    // Log::error("Error fetching" . Carbon::now());
                    // Log::error($current_prices_list_details_from_server);
                } elseif (isset($current_prices_list_details_from_server['status']['error_code'])) {
                    if ($current_prices_list_details_from_server['status']['error_code'] == 429) {
                        return 1;
                    }
                }
                // else {
                //     // Log::error($current_prices_list_details_from_server);
                // }
            }
        }
    }
    public function updateWallet(Request $request)
    {
        $portfolio = Portfolio::where('user_id', Auth::id())->where('id', $request->portfolio_id)->first();
        if (!$portfolio) {
            return redirect()->back();
        }
        if (!isset($request->wallet_address)) {
            Wallet::where('portfolio_id', $portfolio->id)
                ->delete();
            return redirect()->back();
        }
        $existing_wallets = $portfolio->wallets()->get()->pluck('wallet_address')->toArray();

        $new_wallets = array_map('strtolower', $request->wallet_address);
        $new_wallets = array_values(array_unique($new_wallets));

        $wallets_to_add = array_diff($new_wallets, $existing_wallets);
        $wallets_to_remove = array_diff($existing_wallets, $new_wallets);
        foreach ($wallets_to_add as $wallet_address) {
            // $wallet_address_encrypted = (new Wallet)->encryptAttribute($wallet_address);
            Wallet::create([
                'portfolio_id' => $portfolio->id,
                'wallet_address' => $wallet_address
            ]);
        }
        foreach ($wallets_to_remove as $wallet_address) {
            $wallet_address_encrypted = (new Wallet)->encryptAttribute($wallet_address);
            Wallet::where('portfolio_id', $portfolio->id)
                ->where('wallet_address', $wallet_address_encrypted)
                ->delete();
        }
        return redirect()->back();
    }
}
