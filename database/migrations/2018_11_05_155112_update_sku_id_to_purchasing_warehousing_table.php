<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSkuIdToPurchasingWarehousingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchasing_warehousing', function (Blueprint $table) {
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
        Schema::table('purchasing_warehousing', function (Blueprint $table) {
            //
        });
    }
}
