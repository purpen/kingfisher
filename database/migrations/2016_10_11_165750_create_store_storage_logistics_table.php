<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreStorageLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_storage_logistics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unique();//店铺ｉｄ
            $table->integer('storage_id');//仓库ｉｄ
            $table->integer('logistics_id');//快递ｉｄ
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
        Schema::drop('store_storage_logistics');
    }
}
