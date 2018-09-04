<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_region', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id');
            $table->integer('user_id');//创建人id
            $table->integer('min');//下限数量
            $table->integer('max');//上限数量
            $table->decimal('sell_price', 10,2);//销售价格
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
        Schema::drop('sku_region');
    }
}
