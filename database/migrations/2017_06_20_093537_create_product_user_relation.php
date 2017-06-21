<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductUserRelation extends Migration
{
    /*
    id	int(10)	否
    product_id	int()	否		商品ID
    user_id	int(11)	否		用户ID，当为0时表示全部可查看
    price	decimal(10,2)	否	0	供货价
    */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_user_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->decimal('price', 10,2)->nullable();
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
        Schema::drop('product_user_relation');
    }
}
