<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        //入库表单
        Schema::create('enter_warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);              //编号
            $table->integer('target_id');             //关联ID: 采购、订单退货、调拨
            $table->tinyInteger('type')->default(1);  //类型：1. 采购；2.订单退货；3.调拔
            $table->integer('storage_id');
            $table->integer('count')->default(0);
            $table->integer('in_count')->default(0);
            $table->integer('user_id');
            $table->tinyInteger('storage_status')->default(0);  //入库状态：0.未入库；1.入库中；5.已入库
            $table->tinyInteger('status')->default(1);
            $table->string('summary',500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //入库表单明细
        Schema::create('enter_warehouse_sku_relation',function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enter_warehouse_id');
            $table->integer('sku_id');
            $table->integer('count')->default(0);
            $table->integer('in_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        //出库表单
        Schema::create('out_warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);              //编号
            $table->integer('target_id');             //关联ID: 采购退货、销售、调拨
            $table->tinyInteger('type')->default(1);  //类型：1. 采购退货；2.订单；3.调拔
            $table->integer('storage_id');
            $table->integer('count')->default(0);
            $table->integer('out_count')->default(0);
            $table->integer('user_id');
            $table->tinyInteger('storage_status')->default(0);  //出库状态：0.出入库；1.出库中；5.已出库
            $table->tinyInteger('status')->default(1);
            $table->string('summary',500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //出库表单明细
        Schema::create('out_warehouse_sku_relation',function (Blueprint $table) {
            $table->increments('id');
            $table->integer('out_warehouse_id');
            $table->integer('sku_id');
            $table->integer('count')->default(0);
            $table->integer('out_count')->default(0);
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
        Schema::drop('enter_warehouse_sku_relation');
        Schema::drop('out_warehouses');
        Schema::drop('out_warehouse_sku_relation');
    }
}
