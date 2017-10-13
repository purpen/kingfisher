<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakeStockDetailed extends Migration
{
    /**
     * storage_sku_count_id    int(10)    否        仓库对应的sku库存表ID
     * department    varchar(50)    否        部门
     * product_id    int(10)    否        商品ID
     * product_number    varchar(20)    否        商品编号
     * sku_id    int(11)    否    0    sku ID
     * sku_number    varchar(20)    否        sku编号
     * name    varchar(100)    否        商品名称
     * mode    varchar(100)    否        型号
     * number    int(10)    否    0    数量
     * storage_number    int(10)    否        实际库存数量
     */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('take_stock_detailed', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storage_sku_count_id');
            $table->string('department', 50);
            $table->integer('product_id');
            $table->string('product_number', 20);
            $table->integer('sku_id');
            $table->string('sku_number');
            $table->string('name', 100);
            $table->string('mode', 100);
            $table->integer('number')->default(0);
            $table->integer('storage_number')->default(0);
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
        Schema::drop('take_stock_detailed');
    }
}
