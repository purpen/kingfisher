<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单明细表
        Schema::create('supplier_month', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_name', 30);
            $table->string('year_month', 20);
            $table->decimal('total_price',10,2)->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('supplier_month');

    }
}
