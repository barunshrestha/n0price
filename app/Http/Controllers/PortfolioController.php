<?php

namespace App\Http\Controllers;

use App\Models\AssetMatrixConstraints;
use App\Models\Portfolio;
use App\Models\SelectedPortfolio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    private $_page = "pages.ManagePortfolio.";
    private $_data = [];
    public function __construct()
    {
        $this->_data['page_title'] = 'Portfolio';
    }

    public function index()
    {
        $portfolio = Portfolio::where('user_id', Auth::id())->get(['id', 'portfolio_name']);
        $this->_data['portfolios'] = $portfolio;
        $selected_portfolio = SelectedPortfolio::where('user_id', Auth::id())->get(['portfolio_id']);
        $this->_data['selected_portfolio'] = $selected_portfolio[0];
        return view($this->_page . 'index', $this->_data);
    }
    public function active($id){
        $user=Auth::user();
        SelectedPortfolio::where('user_id', $user->id)->update(['portfolio_id'=>$id]);
        return redirect()->back()->with(['success' =>"Active Portfolio Changed" ]);
    }
    public function edit(Request $request,$id){
        // 
    }
    public function update(Request $request){
        // 
    }
    public function destroy($id){
        $portfolio = Portfolio::where('user_id', Auth::id())->where('id',$id)->get();
        $selected_portfolio = SelectedPortfolio::where('user_id', Auth::id())->get(['portfolio_id']);
        if($selected_portfolio[0]->portfolio_id==$id){
            return redirect()->back()->with(['fail' =>"Cannot Delete Active Portfolio" ]);
        }
        Portfolio::where('user_id', Auth::user()->id)->where('id',$id)->delete();
        // $portfolio->delete();
        return redirect()->back()->with(['success' =>"Portfolio has been removed" ]);
    }

    public function store(Request $request){
        $allocation_percentage=$request->allocation_percentage;
        $user=Auth::user();
        $date = Carbon::now();
        $portfolio=new Portfolio();
        $portfolio->user_id=$user->id;
        $portfolio->portfolio_name=$request->portfolio_name;
        $portfolio->save();
        $data = [
            ['percentage_allocation'=>$allocation_percentage[0],'portfolio_id'=>$portfolio->id,'user_id' => $user->id, 'risk' => 'Very High', 'market_cap' => '<25M', 'color' => '#e9fac8', 'created_at' => $date, 'updated_at' => $date],
            ['percentage_allocation'=>$allocation_percentage[1],'portfolio_id'=>$portfolio->id,'user_id' => $user->id, 'risk' => 'High', 'market_cap' => '25M - 250M', 'color' => '#fff3bf', 'created_at' => $date, 'updated_at' => $date],
            ['percentage_allocation'=>$allocation_percentage[2],'portfolio_id'=>$portfolio->id,'user_id' => $user->id, 'risk' => 'Medium', 'market_cap' => '250M - 1B', 'color' => '#d3f9d8', 'created_at' => $date, 'updated_at' => $date],
            ['percentage_allocation'=>$allocation_percentage[3],'portfolio_id'=>$portfolio->id,'user_id' => $user->id, 'risk' => 'Low', 'market_cap' => '1B - 25B', 'color' => '#ffd8a8', 'created_at' => $date, 'updated_at' => $date],
            ['percentage_allocation'=>$allocation_percentage[4],'portfolio_id'=>$portfolio->id,'user_id' => $user->id, 'risk' => 'Very Low', 'market_cap' => '>25B', 'color' => '#ffa8a8', 'created_at' => $date, 'updated_at' => $date],
        ];
        AssetMatrixConstraints::insert($data);
        return redirect()->back()->with(['success' =>"Portfolio has been added." ]);
    }
}
