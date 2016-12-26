<?php

/**
 * out_storage_id	varchar(20)	 是		(自营平台)来自店铺ID
 * vop_id	        varchar(20)  是		开普勒skuID
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVopToOrderSkuRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_sku_relation', function (Blueprint $table) {
            $table->string('out_storage_id')->default('');
            $table->string('vop_id')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_sku_relation', function (Blueprint $table) {
            $table->dropColumn(['out_storage_id','vop_id']);
        });
    }
}
