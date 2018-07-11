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
            $table->string('name',50);  //姓名
            $table->string('store_name',50);  //门店名称
            $table->string('store_address',100);  //门店地址
            $table->string('operation_situation',150);  //经营情况
            $table->integer('cover_id');//图片id
            $table->string('bank_number',50);  //银行账号
            $table->string('bank_name',20);  //开户行
            $table->string('business_license_number',20);  //营业执照号
            $table->string('taxpayer',20);  //纳税人(一般/小规模等)
            $table->integer('area_id')->default(0); //地域分类id
            $table->integer('authorization_id')->default(0); //授权条件id
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
