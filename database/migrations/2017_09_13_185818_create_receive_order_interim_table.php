<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiveOrderInterimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单明细表
        Schema::create('receive_order_interim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_sku_relation_id');
            $table->integer('quantity');
            $table->string('store_name', 30);
            $table->string('product_title', 30);
            $table->string('supplier_name', 30);
            $table->string('order_type', 30);
            $table->string('buyer_name', 30);
            $table->decimal('price',10,2)->default(0);
            $table->decimal('cost_price',10,2)->default(0);
            $table->decimal('total_money',10,2)->default(0);
            $table->dateTime('order_start_time');
            $table->dateTime('invoice_start_time');
            $table->dateTime('receive_time');
            $table->decimal('amount',10,2)->default(0);
            $table->string('summary', 100);
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
        Schema::drop('receive_order_interim');

    }
}
