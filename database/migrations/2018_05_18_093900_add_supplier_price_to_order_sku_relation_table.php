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
            $table->decimal('supplier_price',10,2);        //供应商成本价
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
            $table->dropColumn('supplier_price');
        });
    }
}
