<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use DateTime;
use DateTimeZone;

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
        $today = date('Y-m-d');
        $this->_data['sub_date'] = date('Y-m-d', strtotime($today . '-4 days'));
        
        $this->_data['month'] = "";
       
        return view($this->_page.'dashboard',$this->_data);
    }

    
}

