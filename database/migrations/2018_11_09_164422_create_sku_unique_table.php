<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuUniqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_unique', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id'); //审核人
            $table->integer('purchase_id'); //审核人
            $table->integer('storage_id'); //审核人
            $table->tinyInteger('status'); //审核人
            $table->tinyInteger('type'); //审核人
            $table->double('price',10,2)->default(0);//审核时间
            $table->softDeletes();
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
        Schema::drop('sku_unique');
    }
}
