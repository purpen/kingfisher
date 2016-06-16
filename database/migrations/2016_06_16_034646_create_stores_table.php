<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*
    id	int(11)	否
    name	varchar(30)	否		名称
    number	varchar(10)	否		编号
    target_id	varchar(15)	是		关联站外店铺ID
    outside_info	json	是		站外店铺接入信息
    type	tinyint(1)	否	1	类型：1.线上；2.线下
    status	tinyint(1)	否	1	状态：1.禁用；2.正常
    user_id	int(11)	否		用户ID
    summary	varchar(500)	否		备注
    */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);  //名称
            $table->string('number',10);  //编号
            $table->string('target_id',15)->nullable();  //关联站外店铺ID
            $table->string('outside_info')->nullable();  //站外店铺接入信息
            $table->tinyInteger('type')->default(1);     //类型：1.线上；2.线下
            $table->tinyInteger('status')->default(1);   //状态：1.禁用；2.正常
            $table->integer('user_id');
            $table->string('summary',500);
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
        Schema::drop('stores');
    }
}
