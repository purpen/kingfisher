<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_out', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id');//sku_id
            $table->integer('storage_id');//仓库ID
            $table->integer('order_id');//订单ID
            $table->integer('user_id');//操作人
            $table->string('number',20); //数量
            $table->tinyInteger('department'); //部门
            $table->dateTime('outage_time');//出库时间
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
        Schema::drop('order_out');
    }
}
