<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');//用户id
            $table->string('name',50);  //姓名
            $table->string('store_name',50);  //门店名称
            $table->string('store_address',100);  //门店地址
            $table->string('operation_situation',150);  //经营情况
            $table->integer('front_id');//门店正面照片
            $table->integer('Inside_id');//门店内部照片
            $table->integer('portrait_id');//身份证人像面
            $table->integer('license_id');//营业执照
            $table->integer('national_emblem_id');//身份证国徽面
            $table->string('bank_number',50);  //银行账号
            $table->string('bank_name',20);  //开户行
            $table->string('business_license_number',20);  //营业执照号
            $table->string('taxpayer',20)->default(0);  //纳税人(一般/小规模等)
            $table->integer('province_id')->default(0);//省id
            $table->integer('city_id')->default(0);//市id
            $table->string('authorization_id',50); //授权条件id(多个)
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
        Schema::drop('distributors');
    }
}
