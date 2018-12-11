<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('route_id')->default(0);
            $table->integer('image_id')->default(0);
            $table->string('number');
            $table->text('coordinates');
            $table->integer('question_id')->default(0);
            $table->text('how_to_get');
            $table->text('btw');
            $table->string('name')->default(NULL);
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
        Schema::drop('points');
    }
}
