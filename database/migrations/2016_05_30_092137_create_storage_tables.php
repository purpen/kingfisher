<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建storage 仓库表
        Schema::create('storages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->nullable();
            $table->string('number',10);
            $table->string('address', 50)->nullable();
            $table->string('content', 500)->nullable();
            $table->tinyInteger('type')->default(1);
            $table->integer('user_id');
            $table->tinyInteger('city_id')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });


        //创建 库区表 storage_rack
        Schema::create('storage_racks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->nullable();
            $table->string('number', 30);
            $table->integer('storage_id');
            $table->string('content', 500)->nullable();
            $table->tinyInteger('type')->default(1);
            $table->integer('user_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });


        //创建 storage_place 库位表
        Schema::create('storage_places', function (Blueprint $table){
            $table->increments('id');
            $table->string('name', 30)->nullable();
            $table->string('number', 30);
            $table->integer('storage_rack_id');
            $table->string('content', 500)->nullable();
            $table->tinyInteger('type')->default(1);
            $table->integer('user_id');
            $table->tinyInteger('status')->default(1);
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
        Schema::drop('storages');
        Schema::drop('storage_racks');
        Schema::drop('storage_places');
    }
}
