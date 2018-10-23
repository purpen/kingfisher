<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutgoingLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_logistics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logistics_company',50); //物流公司
            $table->string('odd_numbers',100); //物流单号
            $table->integer('order_id');//订单id
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
        Schema::drop('outgoing_logistics');
    }
}
