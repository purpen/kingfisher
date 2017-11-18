<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueNumberToProductsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_sku', function (Blueprint $table) {
            $table->string('unique_number', 20);

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
            $table->dropColumn('unique_number');
        });
    }
}