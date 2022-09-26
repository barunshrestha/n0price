<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UspGetCurrentTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(" DROP PROCEDURE IF EXISTS usp_get_current_transaction");
        $procedure = "CREATE PROCEDURE usp_get_current_transaction(IN current_user_id varchar(50))
        BEGIN       
        Select tb.coin_name,tb.coin_id,tb.symbol,tb.id_of_coin,tb.image,tb.user_id,tb.total as buy_unit,tb.total_profit as total_profit, vw_total_sell.total as sell_unit,
        tb.total_investment as buy_amount,vw_total_sell.total_investment as sell_amount
        from vw_total_buy as tb LEFT JOIN vw_total_sell ON tb.coin_id = vw_total_sell.coin_id AND tb.user_id=vw_total_sell.user_id where tb.user_id= current_user_id;     
        END";

        DB::statement($procedure);
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
