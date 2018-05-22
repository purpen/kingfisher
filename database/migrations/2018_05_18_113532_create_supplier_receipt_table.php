<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_receipt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_user_id')->nullable();
            $table->integer('user_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('total_price',10,2);
            $table->tinyInteger('status')->default(0);//0. 默认1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
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
        Schema::drop('supplier_receipt');
    }
}
