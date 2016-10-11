<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreLogisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_logistic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');
            $table->integer('logistic_id')->default(1);//默认ｉｄ为１的快递
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
        Schema::drop('store_logistic');
    }
}
