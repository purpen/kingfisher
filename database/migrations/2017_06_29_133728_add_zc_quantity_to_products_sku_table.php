<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZcQuantityToProductsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_sku', function (Blueprint $table) {
            $table->integer('zc_quantity')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_sku', function (Blueprint $table) {
            $table->dropColumn(['zc_quantity']);

        });
    }
}
