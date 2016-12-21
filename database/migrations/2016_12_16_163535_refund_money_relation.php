<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefundMoneyRelation extends Migration
{
    /*id	int(11)	否
    refund_money_order_id	int(11)	否		退货单ID
    sku_id	int(11)	否		skuID
    sku_number	varchar(20)	否		sku编号
    quantity	int(5)	是	0	数量
    price	decimal(10,2)	否	0	单价
    name	varchar(20)	否		商品名称
    mode	varchar(20)	否		型号
    status	tinyint(1)	否	0	0.*/

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_money_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('refund_money_order_id');
            $table->integer('sku_id');
            $table->string('sku_number',20);
            $table->integer('quantity')->default(0);
            $table->decimal('price',10,2)->default(0);
            $table->string('name',20);
            $table->string('mode',20);
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('refund_money_relation');
    }
}
