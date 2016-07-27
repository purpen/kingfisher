<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //采购退货单
        Schema::create('returned_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);       //编号
            $table->integer('purchase_id');
            $table->integer('storage_id');
            $table->integer('supplier_id');
            $table->integer('count')->default(0);
            $table->integer('out_count')->default(0);
            $table->integer('user_id');
            $table->integer('verify_user_id')->nullable();
            $table->decimal('price',10,2);
            $table->tinyInteger('verified')->default(0);
            $table->tinyInteger('storage_status')->default(0);  //出库状态： 0.未出库；1.出库中；5.已出库
            $table->tinyInteger('status')->default(1);
            $table->string('summary',500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        //退货单明细
        Schema::create('returned_sku_relation',function (Blueprint $table){
            $table->increments('id');
            $table->integer('returned_id');
            $table->integer('sku_id');
            $table->decimal('price',10,2);
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
        Schema::drop('returned_purchases');
        Schema::drop('returned_sku_relation');

    }
}
