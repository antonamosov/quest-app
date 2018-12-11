<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BackgroundImageToLandings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('landings', function(Blueprint $table) {
            $table->string('background_image_id');
        });

        Schema::table('preview_landings', function(Blueprint $table) {
            $table->string('background_image_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('landings', function(Blueprint $table) {
            $table->dropColumn('background_image_id');
        });

        Schema::table('preview_landings', function(Blueprint $table) {
            $table->dropColumn('background_image_id');
        });
    }
}
