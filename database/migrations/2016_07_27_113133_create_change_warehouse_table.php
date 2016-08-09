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
        //库房调拨表单
        Schema::create('change_warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);              //编号
            $table->integer('out_storage_id');        //调出仓库ID
            $table->integer('in_storage_id');         //调入仓库ID
            $table->integer('count')->default(0);
            $table->integer('user_id')->nullable();
            $table->integer('verify_user_id')->nullable();
            $table->dateTime('verify_time')->nullable();
            $table->tinyInteger('verified')->default(0); //审核状态：0.未审核；1.业管主管；9.通过
            $table->tinyInteger('storage_status')->default(0);  //入库状态：0.未开始；1.调拔中；5.完成
            $table->tinyInteger('status')->default(1);
            $table->string('summary',500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        //调拨单明细表
        Schema::create('change_warehouse_sku_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('change_warehouse_id');                 //调拨单ID
            $table->integer('sku_id');
            $table->integer('count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        //sku对应各仓库库存
        Schema::create('storage_sku_count', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storage_id');                          //仓库ID
            $table->integer('storage_rack_id')->nullable();         //库区ID
            $table->integer('storage_place_id')->nullable();        //仓位ID
            $table->integer('sku_id');
            $table->integer('count')->default(0);
            $table->integer('product_id');
            $table->string('product_number',20);
            $table->integer('min_count')->default(0);
            $table->integer('max_count')->default(0);
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
        Schema::drop('change_warehouse');
        schema::drop('change_warehouse_sku_relation');
        Schema::drop('storage_sku_count');
    }
}
