<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products',function (Blueprint $table){
            $table->increments('id');
            $table->string('title',50);
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('supplier_id');
            $table->tinyInteger('type');
            $table->decimal('market_price',10,2);
            $table->decimal('sale_price',10,2);
            $table->integer('inventory');
            $table->decimal('weight',5,2)->nullable();
            $table->integer('cover_id');
            $table->string('unit',10);
            $table->tinyInteger('published')->default(0);
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
        Schema::drop('products');
    }
}
