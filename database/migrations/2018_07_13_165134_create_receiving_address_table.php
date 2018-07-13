<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivingAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiving_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address', 200)->nullable();//收货地址
            $table->string('province', 20);//省
            $table->string('city', 20);//市
            $table->string('county', 20);//区/县
            $table->string('name', 20);//收件人
            $table->string('phone', 20);//手机号
            $table->string('zip', 20);//邮编
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
        Schema::drop('receiving_address');
    }
}
