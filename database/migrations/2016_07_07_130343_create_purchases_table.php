<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //采购单表
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);
            $table->integer('storage_id');
            $table->integer('supplier_id');
            $table->integer('user_id');
            $table->integer('count')->default(0);
            $table->integer('in_count')->default(0);
            $table->decimal('price',10,2);
            $table->tinyInteger('verified')->default(0);
            $table->tinyInteger('storage_status')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->string('summary',500)->nullable();
            $table->string('paymentcondition',60)->nullable();
            $table->string('msg',50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        //采购单明细
        Schema::create('purchase_sku_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
            $table->integer('sku_id');
            $table->decimal('price',10,2);
            $table->integer('count')->default(0);
            $table->integer('in_count')->default(0);
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
        Schema::drop('purchases');
        Schema::drop('purchase_sku_relation');
    }
}
