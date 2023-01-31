<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SellView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    //     DB::statement("drop view if exists vw_total_sell ");
    //     DB::statement("create view vw_total_sell as
    //     select coins.name as coin_name,coins.coin_id as coin_id,coins.symbol as symbol,transactions.portfolio_id as portfolio_id,
    //     sum(units)as total,coins.id as id_of_coin,coins.image as image,
    //     sum(transactions.purchase_price) as total_investment,
    //     transactions.user_id as user_id
    //     from transactions join coins on transactions.coin_id=coins.id where investment_type='sell' group by coin_id,user_id,coins.name,coins.symbol,coins.id,coins.image,transactions.portfolio_id;
    //   ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS vw_total_sell');
    }
}
