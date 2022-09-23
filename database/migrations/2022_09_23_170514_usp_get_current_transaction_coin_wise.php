<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UspGetCurrentTransactionCoinWise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DELIMITER //
        CREATE PROCEDURE usp_get_current_transaction_coin_wise(IN current_user_id varchar(50),IN current_coin_id varchar(50))
        BEGIN      
        Select tb.coin_name,tb.coin_id,tb.symbol,tb.id_of_coin,tb.image,tb.user_id,tb.total as buy_unit, vw_total_sell.total as sell_unit,
        tb.total_investment as buy_amount,vw_total_sell.total_investment as sell_amount
        from vw_total_buy as tb LEFT JOIN vw_total_sell ON tb.coin_id = vw_total_sell.coin_id AND tb.user_id=vw_total_sell.user_id where tb.user_id= current_user_id
        and tb.id_of_coin=current_coin_id;
        END //
        DELIMITER ;;";
  
        DB::unprepared($procedure);
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
