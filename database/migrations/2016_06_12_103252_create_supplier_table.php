<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     */
    public function up()
    {
        //创建供应商表单
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);  //公司全称
            $table->string('nam',50);  //简称
            $table->string('address',100);  //地址
            $table->string('legal_person',15);  //法人
            $table->string('tel',15);  //电话
            $table->string('ein',20);  //税号
            $table->string('bank_number',20);  //开户行号
            $table->string('bank_address',50);  //开户行地址
            $table->tinyInteger('general_taxpayer')->default(0);  //纳税人
            $table->string('contact_user',15);  //联系人
            $table->string('contact_number',20);  //联系电话
            $table->string('contact_email',50)->nullable();  //联系邮箱
            $table->string('contact_qq',20)->nullable();  //联系人QQ
            $table->string('contact_wx',30)->nullable();  //联系人微信
            $table->string('msg',200)->nullable();
            $table->tinyInteger('type')->default(1);
            $table->integer('user_id');
            $table->tinyInteger('status')->default(1);  //状态：1.禁用；2.正常
            $table->string('summary',500); //备注
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
        Schema::drop('suppliers');
    }
}
