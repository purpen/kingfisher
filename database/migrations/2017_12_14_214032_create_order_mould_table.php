<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMouldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_moulds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20);
            $table->string('mark', 20)->default('');
            $table->integer('user_id');
            $table->integer('sort')->default(0);
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('kind')->default(1);
            $table->tinyInteger('status')->default(0);
            // 订单信息
            $table->integer('outside_target_id')->default(0);
            $table->integer('summary')->default(0);
            $table->integer('buyer_summary')->default(0);
            $table->integer('seller_summary')->default(0);
            $table->integer('order_start_time')->default(0);
            // 产品信息
            $table->integer('sku_number')->default(0);
            $table->integer('sku_count')->default(0);
            // 收货人信息
            $table->integer('buyer_name')->default(0);
            $table->integer('buyer_tel')->default(0);
            $table->integer('buyer_phone')->default(0);
            $table->integer('buyer_zip')->default(0);
            $table->integer('buyer_province')->default(0);
            $table->integer('buyer_city')->default(0);
            $table->integer('buyer_county')->default(0);
            $table->integer('buyer_township')->default(0);
            $table->integer('buyer_address')->default(0);
            // 发票信息
            $table->integer('invoice_type')->default(0);
            $table->integer('invoice_header')->default(0);
            $table->integer('invoice_info')->default(0);
            $table->integer('invoice_added_value_tax')->default(0);
            $table->integer('invoice_ordinary_number')->default(0);
            // 物流信息
            $table->integer('express_content')->default(0);
            $table->integer('express_name')->default(0);
            $table->integer('express_no')->default(0);
            // 快递费，优惠金额
            $table->integer('freight')->default(0);
            $table->integer('discount_money')->default(0);
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
        Schema::drop('order_moulds');
    }
}
