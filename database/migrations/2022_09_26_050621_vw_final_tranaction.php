<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VwFinalTranaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("drop view if exists vw_final_transaction");
        DB::statement("create view vw_final_transaction as select tb.coin_name AS coin_name,tb.coin_id AS coin_id,tb.symbol AS symbol,
        tb.id_of_coin AS id_of_coin,tb.image AS image,tb.user_id AS user_id,tb.total AS buy_unit,vw_total_sell.total AS sell_unit,
        tb.total_investment AS buy_amount,vw_total_sell.total_investment AS sell_amount,tb.portfolio_id as portfolio_id from (vw_total_buy tb left join vw_total_sell 
        on(tb.coin_id = vw_total_sell.coin_id and tb.user_id = vw_total_sell.user_id)) 
        group by tb.user_id,
        tb.coin_name,
        tb.coin_id,
        tb.symbol,
        tb.id_of_coin,tb.image,
        tb.total,
        vw_total_sell.total,
        tb.total_investment,
        vw_total_sell.total_investment,tb.portfolio_id");
    
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
