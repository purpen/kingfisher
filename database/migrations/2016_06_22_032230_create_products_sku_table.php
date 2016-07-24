<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     */
    public function up()
    {
        Schema::create('products_sku', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('name',50);
            $table->string('number',20);
            $table->string('mode',20);
            $table->decimal('price',10,2)->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('user_id');
            $table->integer('min_count')->default(0);
            $table->integer('max_count')->default(0);
            $table->integer('storage_place_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_sku');
    }
}
