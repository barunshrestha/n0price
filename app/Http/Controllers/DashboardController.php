<?php

namespace App\Http\Controllers;

use App\Models\AssetMatrixConstraints;
use App\Models\Coin;
use App\Models\Transaction;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $_page = "pages.";
    private $_data = [];

    public function __construct()
    {
        $this->_data['page_title'] = 'Dashboard';
    }

    public function index(Request $request)
    {

        $user = Auth::user();
        $this->_data['user'] = $user;

        $asset_matrix_constraints = AssetMatrixConstraints::where('user_id', Auth::user()->id)->get();
        $this->_data['asset_matrix_constraints'] = $asset_matrix_constraints;
        // $this->_data['returns_on_current_date'] = $this->return_calculation();

        return view($this->_page . 'dashboard', $this->_data);
    }
    public function get_transaction_of_specific_user()
    {
        $user = Auth::user();
        $transactions = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->where('transactions.user_id', $user->id)
            ->select(DB::raw('coins.name as coin_name,coins.image as image,transactions.*'))
            ->get();
        // $this->_data['transactions'] = $transactions;
        return response()->json(["data" => $transactions]);
    }

    public function portfolio_summary()
    {
        $user = Auth::user();
        $this->_data['user'] = $user;

        $portfolio = DB::select('CALL usp_get_current_transaction(' . $user->id . ')');
        $this->_data['portfolio'] = $portfolio;

        $total_holdings_valuation = 0;
        $total_holdings_valuation_yesterday = 0;
        $total_investment = 0;
        foreach ($portfolio as $stock) {
            $stock->current_holdings = $stock->buy_unit - $stock->sell_unit;
            $coin_id = $stock->coin_id;
            $url = "https://pro-api.coingecko.com/api/v3/simple/price?ids=" . $coin_id . "&vs_currencies=usd&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $current_price = json_decode($response);
            //dd($current_price->$coin_id);
            curl_close($ch);
            $stock->current_price = $current_price->$coin_id->usd;
            $stock->current_value_total = $stock->current_holdings * $stock->current_price;
            $total_holdings_valuation += $stock->current_value_total;
            $yesterday = Carbon::now()->subDays(1)->format('d-m-Y');

            $url = "https://api.coingecko.com/api/v3/coins/" . $coin_id . "/history?date=" . $yesterday . "&localization=false&vs_currencies=usd&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $yesterday_price = json_decode($response);
            if (isset($yesterday_price->market_data)) {
                $stock->yesterday_price = $yesterday_price->market_data->current_price->usd;
                $stock->yesterday_value_total = $stock->yesterday_price * $stock->current_holdings;
                $total_holdings_valuation_yesterday += $stock->yesterday_value_total;
            }

            $stock->total_investment = $stock->buy_amount - $stock->sell_amount;
            $total_investment += $stock->total_investment;
        }
        $this->_data['total_holdings_valuation'] = round($total_holdings_valuation, 2);
        $this->_data['total_holdings_valuation_yesterday'] = $total_holdings_valuation_yesterday;
        $this->_data['total_investment'] = $total_investment;
        //dd($total_holdings_valuation);
        return view($this->_page . 'portfolio_summary', $this->_data);
    }

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
        $available_coins = $query->get();
        return response()->json(["data" => $available_coins, "request" => $data]);
    }
    public function dashboardTransactionPartials(Request $request)
    {
        $user = Auth::user();
        $this->_data['user'] = $user;
        $transactions = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->where('transactions.user_id', $user->id)
            ->select(DB::raw('coins.name as coin_name,coins.image as image,transactions.*'))
            ->orderBy('purchase_date', 'desc')
            ->get();
        $this->_data['transactions'] = $transactions;
        return view($this->_page . 'dashboard-content.' . 'dashboard-transactions-partials', $this->_data);
    }
    public function return_calculation(Request $request)
    {

        $user = Auth::user();
        $portfolio = DB::select('CALL usp_get_current_transaction(' . $user->id . ')');
        $this->_data['portfolio'] = $portfolio;

        $coins_available = DB::select('select coin_name,coin_id,buy_amount,buy_unit,sell_unit from vw_final_transaction where user_id = ?', [$user->id]);

        $buy_transactions = DB::select('select units,name,purchase_price,coin_id from vw_buy_transactions where user_id = ? order by name asc', [$user->id]);
        $sell_transactions = DB::select('select units,name,purchase_price,coin_id from vw_sell_transactions where user_id = ? order by name asc', [$user->id]);
        $total_worth = array();
        $current_transactions = array();

        foreach ($coins_available as $coins) {
            $total_worth = array_merge($total_worth, array($coins->coin_id => $coins->buy_amount));
        }
        foreach ($buy_transactions as $b_t) {
            array_push($current_transactions, array($b_t->coin_id, $b_t->units, $b_t->purchase_price, 0, 0));
        }

        $total_sell_units = array();
        foreach ($sell_transactions as $s_t) {
            array_push($total_sell_units, array($s_t->coin_id, $s_t->units, $s_t->purchase_price));
        }
        foreach ($total_sell_units as $sell_unit) {
            $total_sell_unit = $sell_unit[1];
            // $sell_unit_price = $sell_unit[2] / $sell_unit[1];
            $sell_unit_coin_name = $sell_unit[0];

            if ($total_sell_unit > 0) {
                for ($i = 0; $i < count($current_transactions); $i++) {
                    if ($sell_unit_coin_name == $current_transactions[$i][0]) {
                        $current_transaction = $current_transactions[$i];
                        $purchase_unit_price = $current_transaction[2] / $current_transaction[1];
                        // $profit_loss_rate = $sell_unit_price - $purchase_unit_price;
                        $total_units = $current_transaction[1];
                        $total_debited_units = $current_transaction[3];
                        $slot_units_available = $total_units - $total_debited_units;
                        // $profit_earned = $current_transaction[4];
                        if ($slot_units_available > 0) {
                            if ($slot_units_available >= $total_sell_unit) {
                                if ($total_sell_unit > 0) {
                                    $current_transactions[$i][3] = $total_debited_units + $total_sell_unit;
                                    // $current_transactions[$i][4] = $profit_earned + $profit_loss_rate * $total_sell_unit;

                                    $total_worth[$current_transactions[$i][0]] = $total_worth[$current_transactions[$i][0]] - $total_sell_unit * $purchase_unit_price;


                                    $total_sell_unit = $total_sell_unit - $total_debited_units;
                                    break;
                                }
                            } elseif ($slot_units_available < $total_sell_unit) {
                                if ($total_sell_unit > 0) {
                                    $current_transactions[$i][3] = $total_debited_units + $slot_units_available;
                                    // $current_transactions[$i][4] = $profit_earned + $profit_loss_rate * $slot_units_available;
                                    $total_worth[$current_transactions[$i][0]] = $total_worth[$current_transactions[$i][0]] - $slot_units_available * $purchase_unit_price;
                                    $total_sell_unit = $total_sell_unit - $slot_units_available;
                                }
                            }
                        }
                    }
                }
            }
        }

        $worth = array();
       
        foreach ($coins_available as $coins) {
            $total_current_invested = $total_worth[$coins->coin_id];
            $total_buy = $coins->buy_unit ? $coins->buy_unit : 0;
            $total_sell = $coins->sell_unit ? $coins->sell_unit : 0;
            $remaining_coins = $total_buy - $total_sell;
            $coin_id = "$coins->coin_id";
            $url = "https://api.coingecko.com/api/v3/coins/" .$coin_id . "?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $current_prices_list_details_from_server = json_decode($response);
            $current_market_capital = $current_prices_list_details_from_server->market_data->market_cap->usd;
            $current_price = $current_prices_list_details_from_server->market_data->current_price->usd;
            $price_change_percentage_24h = $current_prices_list_details_from_server->market_data->price_change_percentage_24h;
            $price_change_percentage_7d = $current_prices_list_details_from_server->market_data->price_change_percentage_7d;
            $all_time_high_price_percentage = $current_prices_list_details_from_server->market_data->ath_change_percentage->usd;
            $todaysWorth = $remaining_coins * $current_price;

            if ($total_current_invested == 0) {
                $return = 0;
            } else {
                $return = round(($todaysWorth - $total_current_invested) / $total_current_invested, 2);
            }
            $worth = array_merge($worth, array($coin_id => array("usd_market_cap"=>$current_market_capital,"current_usd"=>$current_price,"return" => $return, "24hr" => round($price_change_percentage_24h, 2), "7d" => round($price_change_percentage_7d, 2), "ATH" => round($all_time_high_price_percentage, 2))));
        }
        $this->_data['worth'] = $worth;
        return view($this->_page . 'dashboard-content.' . 'coin_worth', $this->_data);
    }
}
