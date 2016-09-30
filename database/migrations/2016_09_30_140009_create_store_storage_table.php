<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');
            $table->integer('storage_id')->default(1);//默认ｉｄ为１的仓库
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
        Schema::drop('store_storage');
    }
}
