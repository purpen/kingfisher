<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('product_number', 20);
            $table->integer('sku_id');
            $table->string('sku_number', 20);
            $table->integer('channel_id')->default(0);
            $table->string('code', 20);
            $table->integer('n')->default(1);
            $table->decimal('price',10,2)->default(0);
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->index('user_id');
            $table->index('product_id');
            $table->index('sku_id');
            $table->index('type');
            $table->index('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cart');
    }
}
