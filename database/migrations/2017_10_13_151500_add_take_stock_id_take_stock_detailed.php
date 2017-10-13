<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTakeStockIdTakeStockDetailed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('take_stock_detailed', function (Blueprint $table) {
            $table->integer('take_stock_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('take_stock_detailed', function (Blueprint $table) {
            $table->dropColumn('take_stock_id');
        });
    }
}
