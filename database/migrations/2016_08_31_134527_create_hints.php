<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hints', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('point_id')->default(0);
            $table->timestamps();
            $table->integer('user_id')->default(0);
            $table->integer('question_id')->default(0);
            $table->integer('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hints');
    }
}
