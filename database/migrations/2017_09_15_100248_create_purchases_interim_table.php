<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesInterimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases_interim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_sku_relation_id');
            $table->integer('quantity');
            $table->string('department_name', 30);
            $table->string('product_title', 30);
            $table->string('supplier_name', 30);
            $table->decimal('purchases_price',10,2)->default(0);
            $table->decimal('total_money',10,2)->default(0);
            $table->decimal('payment_price',10,2)->default(0);
            $table->dateTime('purchases_time');
            $table->dateTime('invoice_start_time');
            $table->dateTime('payment_time');
            $table->string('summary', 100);
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
        Schema::drop('purchases_interim');
    }
}
