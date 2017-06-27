<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSkuRelation extends Migration
{
    /*
    id	int(10)	否
    product_user_relation_id	int(10)	否		商品与用户关联表ID
    sku_id	int(10)	否		sku_id
    price	decimal(10,2)	否	0	供货价格
    */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sku_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_user_relation_id');
            $table->integer('sku_id');
            $table->decimal('price')->nullable();
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
        Schema::drop('product_sku_relation');
    }
}
