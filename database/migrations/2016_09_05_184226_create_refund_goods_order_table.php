<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundGoodsOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //refund_goods_order 退货订单表
    public function up()
    {
        Schema::create('refund_goods_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);
            $table->integer('order_id');
            $table->integer('storage_id')->nullable();
            $table->decimal('amount',10,2);
            $table->integer('payment_account');
            $table->tinyInteger('type')->default(1);   //类型：1.售中退款 2.售后退款 3.售后退货--
            $table->integer('user_id');
            $table->string('summary',500);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        //refund_sku_relation 退货订单--商品明细表
        Schema::create('refund_sku_relation',function (Blueprint $table){
            $table->increments('id');
            $table->integer('refund_goods_order_id');
            $table->integer('sku_id');
            $table->integer('quantity')->default(0);
            $table->decimal('price',10,2)->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('refund_goods_order');
        Schema::drop('refund_sku_relation');
        Schema::drop('refund_money_order');
    }
}
