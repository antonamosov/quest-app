<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StyleHederFieldsToLandings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('landings', function(Blueprint $table) {
            $table->string('header_font')->nullable();
            $table->string('header_color')->nullable();
            $table->string('header_font_style')->nullable();
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
            $table->dropColumn('header_font');
            $table->dropColumn('header_color');
            $table->dropColumn('header_font_style');
        });
    }
}
