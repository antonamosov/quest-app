<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('txn_id');
            $table->string('mc_gross');
            $table->string('mc_currency');
            $table->datetime('payment_date');
            $table->string('payment_status');
            $table->string('business');
            $table->string('receiver_email');
            $table->integer('player_id');
            $table->string('player_email');
            $table->integer('relation_id');
            $table->string('relation_type');
            $table->string('code_id');
            $table->string('route_id');
            $table->integer('quantity');
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
        Schema::drop('transactions');
    }
}
