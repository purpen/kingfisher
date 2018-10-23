<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingWarehousingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_warehousing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id');//sku_id
            $table->integer('storage_id');//仓库ID
            $table->integer('purchases_id');//采购单ID
            $table->integer('user_id');//操作人
            $table->string('number',20); //数量
            $table->tinyInteger('department'); //部门
            $table->dateTime('storage_time');//入库时间
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
        Schema::drop('purchasing_warehousing');
    }
}
