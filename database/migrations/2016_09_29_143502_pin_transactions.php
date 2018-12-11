<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PinTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pin_transactions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->boolean('success');
            $table->string('description')->default('');
            $table->string('ip_address')->default('');
            $table->string('status_message')->default('');
            $table->string('error_message')->default('');
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
        Schema::drop('pin_transactions');
    }
}
