<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('coin_id');
            $table->string('symbol');
            $table->unsignedBigInteger('portfolio_id');
            $table->binary('purchase_price_per_unit');
            $table->binary('units');
            $table->string('partial_units_debited')->default('0');
            $table->string('profit_earned')->default('0');
            $table->string('current_rate')->nullable();
            $table->binary('purchase_price');
            $table->string('investment_type');
            $table->date('purchase_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
