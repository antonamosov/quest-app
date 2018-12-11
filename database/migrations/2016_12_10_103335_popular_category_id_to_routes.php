<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopularCategoryIdToRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function(Blueprint $table) {
            $table->integer('popular_category_id')->nullable();
            $table->timestamp('update_popular_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function(Blueprint $table) {
            $table->dropColumn('popular_category_id');
            $table->dropColumn('update_popular_at');
        });
    }
}
