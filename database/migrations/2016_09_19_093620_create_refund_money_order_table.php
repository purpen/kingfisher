<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundMoneyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_money_order',function (Blueprint $table){
            $table->increments('id');
            $table->string('number',20);
            $table->string('out_refund_money_id',20);
            $table->integer('store_id');
            $table->integer('order_id');
            $table->decimal('amount',10,2);
            $table->integer('buyer_id');
            $table->tinyInteger('type')->default(1);
            $table->integer('user_id');
            $table->string('summary',500);
            $table->tinyInteger('status')->default(0);
            $table->dateTime('apply_time');
            $table->dateTime('check_time');
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
        Schema::drop('refund_money_order');
    }
}
