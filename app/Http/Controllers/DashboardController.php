<?php

namespace App\Http\Controllers;

use App\Models\AssetMatrixConstraints;
use App\Models\Coin;
use App\Models\Portfolio;
use App\Models\Query;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    private $_page = "pages.";
    private $_data = [];
    private $_baseurl = "https://pro-api.coingecko.com/api/v3/";
    private $_key = "&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
    private $_currency = "&vs_currencies=usd";

    public function __construct()
    {
        $this->_data['page_title'] = 'Dashboard';
    }

    public function menu_list()
    {
        $user = Auth::user();
        if ($user) {

            $menus = [[]];
            array_push(
                $menus[0],
                [
                    'title' => 'Dashboard',
                    'root' => true,
                    'icon' => 'media/svg/icons/Home/Home.svg', // or can be 'flaticon-home' or any flaticon-*
                    'page' => '/',
                    'new-tab' => false,
                ],

                [
                    'title' => 'Manage Portfolio',
                    'root' => true,
                    'page' => '/portfolio',
                    'icon' => 'media/svg/icons/General/Settings-2.svg', // or can be 'flaticon-home' or any flaticon-*
                    'new-tab' => false,
                ],
                [
                    'section' => 'My Portfolios',
                ]
            );
            $menu_of_portfolio = Portfolio::where('user_id', $user->id)->get(['id', 'portfolio_name']);
            foreach ($menu_of_portfolio as $menu_items) {
                array_push(
                    $menus[0],
                    [
                        'title' => $menu_items->portfolio_name ? $menu_items->portfolio_name : 'Unnamed',
                        'root' => true,
                        'page' => '/select/portfolio/' . $menu_items->id,
                        'icon' => 'media/svg/icons/Clothes/Briefcase.svg', // or can be 'flaticon-home' or any flaticon-*
                        'new-tab' => false,
                    ]
                );
            }
            if (Auth::user()->role_id == 1) {
                array_push(
                    $menus[0],
                    [
                        'section' => 'User',
                    ],
                    [
                        'title' => 'Users',
                        'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                        'bullet' => 'line',
                        'page' => '/users',
                        'root' => true,
                        'new-tab' => false,
                    ],
                    [
                        'section' => 'Coin',
                    ],
                    [
                        'title' => 'Coin',
                        'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                        'bullet' => 'line',
                        'page' => '/coins',
                        'root' => true,
                        'new-tab' => false,
                    ],
                    [
                        'title' => 'Transaction',
                        'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                        'bullet' => 'line',
                        'page' => '/all/transactions',
                        'root' => true,

                    ]
                );
            } else {
            }
            array_push(
                $menus[0],
                [
                    'section' => 'Settings',
                ],
                [
                    'title' => 'Logout',
                    'root' => true,
                    'icon' => 'media/svg/icons/Electric/Shutdown.svg', // or can be 'flaticon-home' or any flaticon-*
                    'page' => '/logout',
                    'new-tab' => false,
                ]
            );
            return $menus;
        }
        return [];
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        (new AuthController)->checkForAssetMatrix_Portfolio($user);
        $this->_data['user'] = $user;
        $selectedPortfolio = Portfolio::where('status', 1)->where('user_id', $user->id)->first();
        $portfolio_id = $selectedPortfolio->id;
        $this->_data['portfolio_details'] = $selectedPortfolio;
        $asset_matrix_total = DB::select('select sum(percentage_allocation) as asset_total from asset_matrix_constraints where user_id =? and portfolio_id=? group by user_id', [$user->id, $portfolio_id]);
        $this->_data['asset_total'] = $asset_matrix_total[0]->asset_total;
        $asset_matrix_constraints = AssetMatrixConstraints::where('user_id', Auth::user()->id)->where('portfolio_id', $portfolio_id)->get();
        $this->_data['asset_matrix_constraints'] = $asset_matrix_constraints;
        if ($asset_matrix_total[0]->asset_total == 0) {
            return view($this->_page . 'no-content-dashboard', $this->_data);
        }
        $all_wallet_address = $selectedPortfolio->wallets()->get()->pluck('wallet_address')->toArray();
        $this->_data['all_wallet_address'] = $all_wallet_address;
        if (!empty($all_wallet_address)) {
            $this->_data['portfolio_id'] = $portfolio_id;
            return view('pages.wallet.dashboard', $this->_data);
        }
        $transaction_count = Transaction::where('user_id', $user->id)->where('portfolio_id', $portfolio_id)->count();
        $this->_data['transaction_count'] = $transaction_count;
        return view($this->_page . 'dashboard', $this->_data);
    }
    public function get_transaction_of_specific_user($portfolio_id)
    {
        $user = Auth::user();
        $selected_portfolio = Portfolio::where('id', $portfolio_id)->where('user_id', $user->id)->get('id');
        $portfolio_id = $selected_portfolio[0]->id;
        $transactions = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.portfolio_id', $portfolio_id)
            ->select(DB::raw('coins.name as coin_name,coins.image as image,transactions.*'))
            ->get();
        return response()->json(["data" => $transactions]);
    }

    // public function portfolio_summary($portfolio_id)
    // {
    //     $user = Auth::user();
    //     $this->_data['user'] = $user;
    //     $selected_portfolio = Portfolio::where('portfolio_id', $portfolio_id)->where('user_id', $user->id)->get('id');
    //     $portfolio_id = $selected_portfolio[0]->id;
    //     $portfolio = DB::select('CALL usp_get_current_transaction(' . $user->id . ',' . $portfolio_id . ')');
    //     $this->_data['portfolio'] = $portfolio;

    //     $total_holdings_valuation = 0;
    //     $total_holdings_valuation_yesterday = 0;
    //     $total_investment = 0;
    //     foreach ($portfolio as $stock) {
    //         $stock->current_holdings = $stock->buy_unit - $stock->sell_unit;
    //         $coin_id = $stock->coin_id;
    //         $url = $this->_baseurl . "simple/price?ids=" . $coin_id . $this->_currency . $this->_key;
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $response = curl_exec($ch);
    //         $current_price = json_decode($response);
    //         curl_close($ch);
    //         $stock->current_price = $current_price->$coin_id->usd;
    //         $stock->current_value_total = $stock->current_holdings * $stock->current_price;
    //         $total_holdings_valuation += $stock->current_value_total;
    //         $yesterday = Carbon::now()->subDays(1)->format('d-m-Y');

    //         $url = $this->_baseurl . "coins/" . $coin_id . "/history?date=" . $yesterday . "&localization=false" . $this->_currency . $this->_key;
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $response = curl_exec($ch);
    //         $yesterday_price = json_decode($response);
    //         if (isset($yesterday_price->market_data)) {
    //             $stock->yesterday_price = $yesterday_price->market_data->current_price->usd;
    //             $stock->yesterday_value_total = $stock->yesterday_price * $stock->current_holdings;
    //             $total_holdings_valuation_yesterday += $stock->yesterday_value_total;
    //         }

    //         $stock->total_investment = $stock->buy_amount - $stock->sell_amount;
    //         $total_investment += $stock->total_investment;
    //     }
    //     $this->_data['total_holdings_valuation'] = round($total_holdings_valuation, 2);
    //     $this->_data['total_holdings_valuation_yesterday'] = $total_holdings_valuation_yesterday;
    //     $this->_data['total_investment'] = $total_investment;
    //     return view($this->_page . 'portfolio_summary', $this->_data);
    // }

    public function getallcoins(Request $request)
    {
        $query = Coin::where('status', '=', '1');
        $data = $request->all();
        if (isset($data['query'])) {
            $searchkeyword = $data['query']['generalSearch'];
            if (isset($searchkeyword)) {
                $query->where('name', 'LIKE', '%' . $searchkeyword . '%');
            }
        }
        $available_coins = $query->limit(100)->get();
        return response()->json(["data" => $available_coins]);
    }
    public function dashboardTransactionPartials(Request $request, $portfolio_id)
    {
        $user = Auth::user();
        if ($portfolio_id != 0) {
            $selected_portfolio = Portfolio::where('user_id', $user->id)->where('id', $portfolio_id)->get('id');
        } else {
            $selected_portfolio = Portfolio::where('user_id', $user->id)->where('status', 1)->get('id');
        }
        $portfolio_id = $selected_portfolio[0]->id;
        $this->_data['user'] = $user;
        $transactions = DB::table('transactions')
            ->join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.portfolio_id', $portfolio_id)
            ->select(DB::raw("coins.name as coin_name,
                            coins.image as image,
                            transactions.id,
                            transactions.user_id,
                            transactions.coin_id,
                            transactions.symbol,
                            transactions.investment_type,
                            transactions.purchase_date,
                            AES_DECRYPT(transactions.units,'BPCJY!US619') as units,
                            AES_DECRYPT(transactions.purchase_price_per_unit,'BPCJY!US619') as purchase_price_per_unit,
                            AES_DECRYPT(transactions.purchase_price,'BPCJY!US619') as purchase_price
                            "))
            ->orderBy('purchase_date', 'desc')
            ->get()
            ->toArray();
        $this->_data['transactions'] = $transactions;
        return view($this->_page . 'dashboard-content.' . 'dashboard-transactions-partials', $this->_data);
    }
    public function return_calculation(Request $request, $portfolio_id)
    {
        $user = Auth::user();
        $selected_portfolio = Portfolio::where('user_id', $user->id)->where('id', $portfolio_id)->get('id');

        $portfolio_id = $selected_portfolio[0]->id;
        $coin_available_query = (new Query)->query_vw_final_transaction($user->id, $portfolio_id);
        $coins_available = DB::select($coin_available_query);
        // $portfolio = DB::select('CALL usp_get_current_transaction(' . $user->id . ',' . $portfolio_id . ')');
        $this->_data['portfolio'] =  $coins_available;
        $buy_transactions_query = (new Query)->query_vw_buy_transaction($user->id, $portfolio_id);
        $sell_transactions_query = (new Query)->query_vw_sell_transaction($user->id, $portfolio_id);
        $buy_transactions = DB::select($buy_transactions_query);
        $sell_transactions = DB::select($sell_transactions_query);
        $total_worth = array();
        $current_transactions = array();
        $total_worth = array_column($coins_available, 'buy_amount', 'coin_id');
        foreach ($buy_transactions as $b_t) {
            $current_transactions[] = [$b_t->coin_id, $b_t->units, $b_t->purchase_price, 0, 0];
        }
        if (!empty($sell_transactions)) {
            $total_sell_units = [];
            foreach ($sell_transactions as $s_t) {
                $total_sell_units[] = [$s_t->coin_id, $s_t->units, $s_t->purchase_price];
            }
            foreach ($total_sell_units as $sell_unit) {
                $total_sell_unit = $sell_unit[1];
                $sell_unit_coin_name = $sell_unit[0];
                if ($total_sell_unit > 0) {
                    if (array_key_exists($sell_unit_coin_name, $current_transactions)) {
                        $current_transaction = $current_transactions[$sell_unit_coin_name];
                        $purchase_unit_price = $current_transaction[2] / $current_transaction[1];
                        $total_units = $current_transaction[1];
                        $total_debited_units = $current_transaction[3];
                        $slot_units_available = $total_units - $total_debited_units;
                        if ($slot_units_available > 0) {
                            if ($slot_units_available >= $total_sell_unit) {
                                $current_transactions[$sell_unit_coin_name][3] = $total_debited_units + $total_sell_unit;
                                $total_worth[$sell_unit_coin_name] = $total_worth[$sell_unit_coin_name] - $total_sell_unit * $purchase_unit_price;
                                break;
                            } elseif ($slot_units_available < $total_sell_unit) {
                                $current_transactions[$sell_unit_coin_name][3] = $total_debited_units + $slot_units_available;
                                $total_worth[$sell_unit_coin_name] = $total_worth[$sell_unit_coin_name] - $slot_units_available * $purchase_unit_price;
                                $total_sell_unit = $total_sell_unit - $slot_units_available;
                            }
                        }
                    }
                }
            }
        }
        $worth = array();
        $ch = curl_init();
        foreach ($coins_available as $coins) {
            $total_current_invested = $total_worth[$coins->coin_id];
            $total_buy = $coins->buy_unit ? $coins->buy_unit : 0;
            $total_sell = $coins->sell_unit ? $coins->sell_unit : 0;
            $remaining_coins = $total_buy - $total_sell;
            $coin_id = "$coins->coin_id";
            $url =  $this->_baseurl . "coins/" . $coin_id . "?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false" . $this->_key;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $current_prices_list_details_from_server = json_decode($response);
            $current_market_capital = isset($current_prices_list_details_from_server->market_data->market_cap->usd) ? $current_prices_list_details_from_server->market_data->market_cap->usd : 0;
            $current_price = isset($current_prices_list_details_from_server->market_data->current_price->usd) ? $current_prices_list_details_from_server->market_data->current_price->usd : 0;
            $price_change_percentage_24h = isset($current_prices_list_details_from_server->market_data->price_change_percentage_24h) ? $current_prices_list_details_from_server->market_data->price_change_percentage_24h : 0;
            $price_change_percentage_7d = isset($current_prices_list_details_from_server->market_data->price_change_percentage_7d) ? $current_prices_list_details_from_server->market_data->price_change_percentage_7d : 0;
            $all_time_high_price_percentage = isset($current_prices_list_details_from_server->market_data->ath_change_percentage->usd) ? $current_prices_list_details_from_server->market_data->ath_change_percentage->usd : 0;
            $todaysWorth = $remaining_coins * $current_price;
            $return = ($todaysWorth - $total_current_invested) / $total_current_invested * 100;
            $return = $total_current_invested == 0 ? 0 : round($return, 2);
            $coinData = [
                "usd_market_cap" => $current_market_capital,
                "current_usd" => $current_price,
                "return" => $return,
                "24hr" => round($price_change_percentage_24h, 2),
                "7d" => round($price_change_percentage_7d, 2),
                "ATH" => round($all_time_high_price_percentage, 2),
            ];
            $worth[$coin_id] = $coinData;
        }
        $this->_data['worth'] = $worth;
        return view($this->_page . 'dashboard-content.' . 'coin_worth', $this->_data);
    }
    public function renderSpecificPortfolio($portfolio_id)
    {
        $user = Auth::user();
        (new AuthController)->checkForAssetMatrix_Portfolio($user);
        $this->_data['user'] = $user;
        $selectedPortfolio = Portfolio::where('user_id', $user->id)->where('id', $portfolio_id)->first();
        if ($selectedPortfolio) {
            $this->_data['page_title'] = $selectedPortfolio->portfolio_name;
            $portfolio_id = $selectedPortfolio->id;
            $this->_data['portfolio_id'] = $portfolio_id;
            $this->_data['portfolio_details'] = $selectedPortfolio;
            $asset_matrix_total = DB::select('select sum(percentage_allocation) as asset_total from asset_matrix_constraints where user_id =? and portfolio_id=? group by user_id', [$user->id, $portfolio_id]);
            $this->_data['asset_total'] = $asset_matrix_total[0]->asset_total;
            $asset_matrix_constraints = AssetMatrixConstraints::where('user_id', Auth::user()->id)->where('portfolio_id', $portfolio_id)->get();
            $this->_data['asset_matrix_constraints'] = $asset_matrix_constraints;
            if ($asset_matrix_total[0]->asset_total == 0) {
                return view($this->_page . 'no-content-dashboard', $this->_data);
            }
            // $all_wallet_address = $selectedPortfolio->wallets()->get()->pluck('wallet_address')->toArray();
            $all_wallet_address = Wallet::where('portfolio_id', $selectedPortfolio->id)->pluck('wallet_address');
            $this->_data['all_wallet_address'] = $all_wallet_address;
            $this->_data['portfolio_id'] = $portfolio_id;
            if (count($all_wallet_address) !== 0) {
                return view('pages.wallet.dashboard', $this->_data);
            }
            $transaction_count = Transaction::where('user_id', $user->id)->where('portfolio_id', $portfolio_id)->count();
            $this->_data['transaction_count'] = $transaction_count;
            return view($this->_page . 'dashboard', $this->_data);
        }
        return redirect()->back();
    }
    public function loadDashboardWithoutLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_address' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        $wallet_address = $request->wallet_address;
        if (gettype($request->wallet_address) == 'string') {
            $wallet_address = explode(',', $request->wallet_address);
        }
        // dd($wallet_address);
        $all_address = array_map('strtolower', $wallet_address);
        $all_wallet_address = array_values(array_unique($all_address));
        $this->_data['wallet_list'] = array_slice($all_wallet_address, 0, 5);
        $this->_data['wallet_address'] = implode(",", $this->_data['wallet_list']);
        return view('pages.noAuthDashboard', $this->_data);
    }
    public function loadDashboardByAddress($address)
    {
        return view('layout.login', compact('address'));
    }
}
