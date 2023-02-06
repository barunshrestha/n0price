<?php

use App\Models\Transaction;
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
        DB::statement("DROP PROCEDURE IF EXISTS usp_get_current_transaction_coin_wise");
        $procedure = "CREATE PROCEDURE usp_get_current_transaction_coin_wise(IN current_user_id varchar(50),IN current_coin_id varchar(50), IN current_portfolio_id varchar(50), IN secret_key varchar(50))
        BEGIN
        Select tb.coin_name,
        tb.coin_id,
        tb.symbol,
        tb.id_of_coin,
        tb.image,
        tb.user_id,
        tb.total as buy_unit,
        ts.total as sell_unit,
        tb.total_investment as buy_amount,
        ts.total_investment as sell_amount
        from (
            SELECT
                coins.name AS coin_name,
                coins.coin_id AS coin_id,
                coins.symbol AS symbol,
                transactions.portfolio_id AS portfolio_id,
                SUM(AES_DECRYPT(units,secret_key)) AS total,
                coins.id AS id_of_coin,
                coins.image AS image,
                SUM(AES_DECRYPT(transactions.purchase_price,secret_key)) AS total_investment,
                transactions.user_id AS user_id
                FROM
                transactions
                JOIN coins ON transactions.coin_id = coins.id
                WHERE
                investment_type = 'buy'
                GROUP BY
                coin_id,
                user_id,
                coins.name,
                coins.symbol,
                coins.id,
                coins.image,
                transactions.portfolio_id
        )
        tb
        LEFT JOIN
        (
            SELECT
                coins.name AS coin_name,
                coins.coin_id AS coin_id,
                coins.symbol AS symbol,
                transactions.portfolio_id AS portfolio_id,
                SUM(AES_DECRYPT(units,secret_key)) AS total,
                coins.id AS id_of_coin,
                coins.image AS image,
                SUM(AES_DECRYPT(transactions.purchase_price,secret_key)) AS total_investment,
                transactions.user_id AS user_id
                FROM
                transactions
                JOIN coins ON transactions.coin_id = coins.id
                WHERE
                investment_type = 'sell'
                GROUP BY
                coin_id,
                user_id,
                coins.name,
                coins.symbol,
                coins.id,
                coins.image,
                transactions.portfolio_id
        )
        ts ON tb.coin_id = ts.coin_id
        AND tb.user_id=ts.user_id
        where tb.user_id= current_user_id
        and tb.id_of_coin=current_coin_id;
        END";

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
