<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageTextToLandings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('landings', function(Blueprint $table) {
            $table->string('image_text');
        });

        Schema::table('preview_landings', function(Blueprint $table) {
            $table->string('image_text');
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
            $table->dropColumn('image_text');
        });

       Schema::table('preview_landings', function(Blueprint $table) {
            $table->dropColumn('image_text');
        });
    }
}
