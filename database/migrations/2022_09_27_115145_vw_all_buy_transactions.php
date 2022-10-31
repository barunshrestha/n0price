<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VwAllBuyTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("drop view if exists vw_buy_transactions");
        DB::statement("create view vw_buy_transactions as 
        select transactions.id, transactions.user_id,transactions.units,transactions.portfolio_id,
        transactions.purchase_price,transactions.purchase_date,
        coins.symbol,coins.name,coins.image,coins.coin_id
        from transactions join coins on transactions.coin_id=coins.id 
        where transactions.investment_type='buy'");
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
