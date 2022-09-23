<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Transaction;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $active_coins = '';
        $query = Coin::where('status', '=', '1');
        $available_coins = $query->get();
        $this->_data['available_coins'] = $available_coins;

        foreach ($available_coins as $key => $value) {
            $active_coins = $active_coins . "," . $value->coin_id;
        }
        $active_coins = ltrim($active_coins, ',');
        $url = "https://pro-api.coingecko.com/api/v3/simple/price?ids=" . $active_coins . "&vs_currencies=usd&include_24hr_vol=true&include_24hr_change=true&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
        // return([$url]);
        // return ([$active_coins]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $current_price = json_decode($response);
        curl_close($ch);
        $this->_data['current_price'] = $current_price;

        // $curr="ethereum";
        // return ([$current_price->$curr]);
        // return ([$current_price->$curr->usd]);

        $user = Auth::user();
        $this->_data['user'] = $user;

        $portfolio = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')->where('user_id', $user->id)
            ->select(DB::raw('coins.name as coin_name,coins.image as image, coins.coin_id as coin_id,coins.symbol as symbol,sum(units) as total,coins.id as id_of_coin, sum(transactions.purchase_price) as total_investment'))
            ->groupBy('coins.name')
            ->groupBy('coins.image')
            ->groupBy('coins.coin_id')
            ->groupBy('coins.symbol')
            ->groupBy('coins.id')
            ->get();

        $total_sell = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')->where('user_id', $user->id)->where('transactions.investment_type', '=', 'sell')
            ->select(DB::raw('coins.name as coin_name,coins.coin_id as coin_id,sum(units) as total,sum(transactions.purchase_price) as total_investment,transactions.investment_type'))
            ->groupBy('coins.name')
            ->groupBy('coins.coin_id')
            ->groupBy('coins.id')
            ->groupBy('transactions.investment_type')
            ->get();

        // return([$total_buy]);

        $this->_data['portfolio'] = $portfolio;
        $this->_data['total_sell'] = $total_sell;

        $portfolio_details = Transaction::all();
        $this->_data['portfolio_details'] = $portfolio_details;

        // return([$this->_data['portfolio_details']]);

        // $transactions = Transaction::where('user_id', $user->id)->join()->get();
        $transactions = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->where('transactions.user_id', $user->id)
            ->select(DB::raw('coins.name as coin_name,coins.image as image,transactions.*'))
            ->get();
        $this->_data['transactions'] = $transactions;

        return view($this->_page . 'dashboard', $this->_data);
    }
}
