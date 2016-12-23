<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxRateToPurchaseSkuRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_sku_relation', function (Blueprint $table) {
            $table->string('tax_rate',10)->nullable();//税率
            $table->decimal('freight',10,2)->default(0);//运费
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_sku_relation', function (Blueprint $table) {
            $table->dropColumn(['tax_rate','freight']);
        });
    }
}
