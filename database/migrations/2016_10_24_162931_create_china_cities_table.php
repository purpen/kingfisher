<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChinaCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('china_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('oid')->unique();   // 唯一标识
            $table->string('name',50);  // 城市名称
            $table->integer('pid')->default(0); // 父ID
            $table->tinyInteger('layer')->default(1);  // 层级
            $table->integer('sort')->default(0); // 排序
            $table->tinyInteger('status')->default(1);  // 状态：0.禁用；1.启用；
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('china_cities');
    }
}
