<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BuyView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("drop view if exists vw_total_buy ");
        DB::unprepared("create view vw_total_buy as
        select coins.name as coin_name,coins.coin_id as coin_id,coins.symbol as symbol,
        sum(units)as total,coins.id as id_of_coin,coins.image as image,
        sum(transactions.purchase_price) as total_investment,transactions.user_id as user_id,sum(profit_earned) as total_profit
        from transactions join coins on transactions.coin_id=coins.id 
        where investment_type='buy' group by coin_id,user_id,coins.name,coins.symbol,coins.id,coins.image;
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS vw_total_buy');
    }
}
