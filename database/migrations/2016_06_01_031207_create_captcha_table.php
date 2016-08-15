<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptchaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建captcha 验证码表
        Schema::create('captcha', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 6);
            $table->string('phone',11)->unique();
            $table->tinyInteger('type')->default(1);  //1.注册；2.登录；3.找回密码；4.--
            $table->tinyInteger('status')->default(1);
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
        // 删除captcha 验证码表
        Schema::drop('captcha');
    }
}
