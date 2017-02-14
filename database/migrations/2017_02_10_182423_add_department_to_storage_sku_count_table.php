<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentToStorageSkuCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //仓库库存
        Schema::table('storage_sku_count', function (Blueprint $table) {
            $table->tinyInteger('department');
        });
        //采购单
        Schema::table('purchases', function (Blueprint $table){
            $table->tinyInteger('department');
        });
        //入库单
        Schema::table('enter_warehouses',function (Blueprint $table){
            $table->tinyInteger('department');
        });
        //调拨单
        Schema::table('change_warehouse', function (Blueprint $table){
            $table->tinyInteger('out_department');
            $table->tinyInteger('in_department');
        });
        //出库单
        Schema::table('out_warehouses', function (Blueprint $table){
           $table->tinyInteger('department');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storage_sku_count', function (Blueprint $table) {
            $table->dropColumn(['department']);
        });
        //采购单
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['department']);
        });
        //入库单
        Schema::table('enter_warehouses', function (Blueprint $table) {
            $table->dropColumn(['department']);
        });
        //调拨单
        Schema::table('change_warehouse', function (Blueprint $table) {
            $table->dropColumn(['out_department','in_department']);
        });
        //出库单
        Schema::table('out_warehouses', function (Blueprint $table) {
            $table->dropColumn(['department']);
        });
    }
}
