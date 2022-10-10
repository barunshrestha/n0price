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

        $portfolio = DB::select('CALL usp_get_current_transaction(' . $user->id . ')');
        $this->_data['portfolio'] = $portfolio;

        $transactions = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->where('transactions.user_id', $user->id)
            ->select(DB::raw('coins.name as coin_name,coins.image as image,transactions.*'))
            ->get();
        $this->_data['transactions'] = $transactions;

        $asset_matrix_constraints = AssetMatrixConstraints::where('user_id', Auth::user()->id)->get();
        $this->_data['asset_matrix_constraints'] = $asset_matrix_constraints;
        return view($this->_page . 'dashboard', $this->_data);
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
            $stock->yesterday_price = $yesterday_price->market_data->current_price->usd;
            $stock->yesterday_value_total = $stock->yesterday_price * $stock->current_holdings;
            $total_holdings_valuation_yesterday += $stock->yesterday_value_total;

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
        return response()->json(["data" => $available_coins,"request"=>$data]);
    }
}
