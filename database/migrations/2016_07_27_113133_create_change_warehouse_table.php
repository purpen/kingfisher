<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enter_warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);              //编号
            $table->integer('target_id');             //关联ID: 采购、订单退货、调拨
            $table->tinyInteger('type')->default(1);  //类型：1. 采购；2.订单退货；3.调拔
            $table->integer('out_storage_id');        //调出仓库ID
            $table->integer('in_storage_id');         //调入仓库ID
            $table->integer('count')->default(0);
            $table->integer('user_id')->nullable();
            $table->integer('verify_user_id')->nullable();
            $table->dateTime('verify_time	datetime')->nullable();
            $table->tinyInteger('storage_status')->default(0);  //入库状态：1.未开始；2.调拔中；5.完成
            $table->tinyInteger('status')->default(1);
            $table->string('summary',500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enter_warehouses');
    }
}
