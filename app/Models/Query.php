<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;

    public function query_vw_final_transaction($user_id, $portfolio_id)
    {
        return "
        WITH
            tb (
                coin_name,
                coin_id,
                symbol,
                portfolio_id,
                total,
                id_of_coin,
                image,
                total_investment,
                user_id
            ) AS (
                SELECT
                coins.name AS coin_name,
                coins.coin_id AS coin_id,
                coins.symbol AS symbol,
                transactions.portfolio_id AS portfolio_id,
                SUM(AES_DECRYPT(units,'secretkey')) AS total,
                coins.id AS id_of_coin,
                coins.image AS image,
                SUM(AES_DECRYPT(transactions.purchase_price,'secretkey')) AS total_investment,
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
            ),
            ts (
                coin_name,
                coin_id,
                symbol,
                portfolio_id,
                total,
                id_of_coin,
                image,
                total_investment,
                user_id
            ) AS (
                SELECT
                coins.name AS coin_name,
                coins.coin_id AS coin_id,
                coins.symbol AS symbol,
                transactions.portfolio_id AS portfolio_id,
                SUM(AES_DECRYPT(units,'secretkey')) AS total,
                coins.id AS id_of_coin,
                coins.image AS image,
                SUM(AES_DECRYPT(transactions.purchase_price,'secretkey')) AS total_investment,
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
            SELECT
            tb.coin_name AS coin_name,
            tb.coin_id AS coin_id,
            tb.symbol AS symbol,
            tb.id_of_coin AS id_of_coin,
            tb.image AS image,
            tb.user_id AS user_id,
            tb.total AS buy_unit,
            ts.total AS sell_unit,
            tb.total_investment AS buy_amount,
            ts.total_investment AS sell_amount,
            tb.portfolio_id as portfolio_id
            from
            tb
            left join ts ON tb.coin_id = ts.coin_id
            and tb.user_id = ts.user_id
            and tb.portfolio_id = ts.portfolio_id
            where tb.user_id='$user_id' and tb.portfolio_id ='$portfolio_id'";
    }

    public function query_vw_buy_transaction($user_id = null, $portfolio_id = null)
    {
        $query = "
        select
            transactions.id,
            transactions.user_id,
            AES_DECRYPT(transactions.units,'secretkey') as units,
            AES_DECRYPT(transactions.purchase_price,'secretkey') as purchase_price,
            transactions.portfolio_id,
            transactions.purchase_date,
            coins.symbol,
            coins.name,
            coins.image,
            coins.coin_id
        from
            transactions
            join coins on transactions.coin_id = coins.id
        where
            transactions.investment_type = 'buy'
        ";
        if (isset($user_id)) {
            $query = $query . " and transactions.user_id='$user_id'";
        }
        if (isset($portfolio_id)) {
            $query = $query . " and transactions.portfolio_id";
        }
        $query = $query . " order by transactions.purchase_date";
        return $query;
    }
    public function query_vw_sell_transaction($user_id = null, $portfolio_id = null)
    {
        $query = "
        select
            transactions.id,
            transactions.user_id,
            AES_DECRYPT(transactions.units,'secretkey') as units,
            AES_DECRYPT(transactions.purchase_price,'secretkey') as purchase_price,
            transactions.portfolio_id,
            transactions.purchase_date,
            coins.symbol,
            coins.name,
            coins.image,
            coins.coin_id
        from
            transactions
            join coins on transactions.coin_id = coins.id
        where
            transactions.investment_type = 'sell'
        ";
        if (isset($user_id)) {
            $query = $query . " and transactions.user_id='$user_id'";
        }
        if (isset($portfolio_id)) {
            $query = $query . " and transactions.portfolio_id";
        }
        $query = $query . " order by transactions.purchase_date";
        return $query;
    }
}
