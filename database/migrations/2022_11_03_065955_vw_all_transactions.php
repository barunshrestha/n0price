<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VwAllTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("drop view if exists vw_all_transactions");
        DB::statement("create view vw_all_transactions as 
        Select t.units as units,t.purchase_price as purchase_price, t.investment_type as status, t.purchase_date as date,
        c.name as coin_name,u.name as username
        from transactions as t
        join coins as c on t.coin_id=c.id
        join users as u on t.user_id=u.id order by t.id desc
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
