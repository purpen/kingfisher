<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //采购单表
        Schema::create('payment_account', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');
            $table->string('bank', 50)->nullable();
            $table->string('account', 30)->nullable();
            $table->string('summary', 30)->nullable();
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
        Schema::drop('payment_account');
    }
}
