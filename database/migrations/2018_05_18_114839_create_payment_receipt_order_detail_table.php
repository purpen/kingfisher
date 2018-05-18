<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentReceiptOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receipt_order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type');//类型：1.渠道付款单ID 2.供应商收款单ID
            $table->integer('target_id');
            $table->integer('quantity')->default(0);
            $table->integer('sku_id');
            $table->string('sku_number',20);
            $table->string('sku_name',50);
            $table->string('favorable')->nullable();
            $table->decimal('price',10,2)->default(0);//优惠信息 [{number:12,price:200,start_time: ,end_time:}]



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
        Schema::drop('payment_receipt_order_detail');
    }
}
