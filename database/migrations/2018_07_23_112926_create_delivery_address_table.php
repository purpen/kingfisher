<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('address', 200);//收货地址
            $table->integer('province_id')->default(0);//省id
            $table->integer('city_id')->default(0);//市id
            $table->integer('county_id')->default(0);//区/县id
            $table->integer('town_id')->default(0);//城镇/乡id
            $table->string('name', 20);//收件人
            $table->string('phone', 20);//手机号
            $table->string('zip', 20)->nullable();//邮编
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('status')->default(1); //状态: 0.禁用；1.正常；
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
        Schema::drop('delivery_address');
    }
}
