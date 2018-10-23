<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllocationOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocation_out', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id');//sku_id
            $table->integer('storage_id');//仓库ID
            $table->integer('allocation_id');//调拨单ID
            $table->integer('user_id');//操作人
            $table->string('number',20); //数量
            $table->tinyInteger('department'); //部门
            $table->tinyInteger('type'); //类型 1.调拨入库2.调拨出库
            $table->dateTime('outorin_time');//出库/入库时间
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
        Schema::drop('allocation_out');
    }
}
