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
        $user = Auth::user();
        $available_coins = Coin::all();
        $this->_data['user'] = $user;
        $this->_data['available_coins'] = $available_coins;

        // $transactions=Transaction::where('user_id',$user->id);
        $portfolio = DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')->where('user_id', $user->id)->select(DB::raw('coins.name as coin_name,sum(units) as total'))
            ->groupBy('coins.name')
            ->get();
        $this->_data['portfolio'] = $portfolio;

        // $transactions = Transaction::where('user_id', $user->id)->join()->get();
        $transactions= DB::table('transactions')->join('coins', 'transactions.coin_id', '=', 'coins.id')
            ->where('transactions.user_id', $user->id)
            ->select(DB::raw('coins.name as coin_name,transactions.*'))
            ->get();
        $this->_data['transactions'] = $transactions;

        return view($this->_page . 'dashboard', $this->_data);
    }
}
