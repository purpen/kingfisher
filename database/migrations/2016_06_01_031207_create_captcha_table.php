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
            $table->tinyInteger('status')->default(1);
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
