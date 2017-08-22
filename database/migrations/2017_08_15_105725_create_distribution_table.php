<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionTable extends Migration
{
    /*
     *  user_id    用户ID
        name   30 名称
        company 50 公司
        Introduction  500  简介
        main   500   主营
        create_time   20  创建时间
        contact_name  20  联系人姓名
        contact_phone  20 联系人手机
        contact_qq    15   联系人qq
     */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name', 30)->default('');
            $table->string('company', 50)->default('');
            $table->string('introduction', 500)->default('');
            $table->string('main', 500)->default('');
            $table->string('create_time', 20)->default('');
            $table->string('contact_name', 20)->default('');
            $table->string('contact_phone', 20)->default('');
            $table->string('contact_qq', 15)->default('');
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
        Schema::drop('distribution');
    }
}
