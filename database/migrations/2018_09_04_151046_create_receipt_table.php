<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('sku_id');
            $table->integer('number')->default(1);
            $table->decimal('price',10,2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->index('user_id');
            $table->index('product_id');
            $table->index('sku_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('receipt');
    }
}
