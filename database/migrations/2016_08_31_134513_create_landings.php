<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('logo_image_id')->default(0);
            $table->integer('main_image_id')->default(0);
            $table->text('header');
            $table->string('background');
            $table->text('faq');
            $table->timestamps();
            $table->integer('user_id')->default(0);
            $table->integer('domain_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('landings');
    }
}
