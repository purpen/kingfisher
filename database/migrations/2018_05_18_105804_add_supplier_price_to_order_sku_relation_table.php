<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplierPriceToOrderSkuRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_sku_relation', function (Blueprint $table) {
            $table->decimal('supplier_price',10,2);
            $table->integer('supplier_receipt_id')->default(0);
            $table->dateTime('supplier_receipt_time');
            $table->dateTime('distributor_payment_time');
            $table->integer('distributor_payment_id')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_sku_relation', function (Blueprint $table) {
            $table->dropColumn(['supplier_price','supplier_receipt_id','supplier_receipt_time','distributor_payment_time','distributor_payment_id']);
        });
    }
}
