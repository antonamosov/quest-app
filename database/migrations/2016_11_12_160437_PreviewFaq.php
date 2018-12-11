<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PreviewFaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preview_faqs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('section_header');
            $table->text('section_txt');
            $table->integer('landing_id')->nullable();
            $table->integer('preview_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::drop('preview_faqs');
    }
}
