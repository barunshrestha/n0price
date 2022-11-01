<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\SelectedPortfolio;
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
        $portfolio->delete();
        return redirect()->back()->with(['success' =>"Portfolio has been removed" ]);
    }
}
