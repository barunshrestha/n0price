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
             
        return view($this->_page.'dashboard',$this->_data);
    }

    
}

