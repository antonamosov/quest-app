<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PreviewLandingsCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preview_landings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('landing_id');
            $table->integer('main_image_id');
            $table->integer('logo_image_id');
            $table->string('background');
            $table->text('header');
            $table->text('faq');
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
        Schema::drop('preview_landings');
    }
}
