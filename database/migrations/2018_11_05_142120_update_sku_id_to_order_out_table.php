<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSkuIdToOrderOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_out', function (Blueprint $table) {
            $table->string('number', 200)->change();
            $table->dropColumn('sku_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_out', function (Blueprint $table) {
            //
        });
    }
}
