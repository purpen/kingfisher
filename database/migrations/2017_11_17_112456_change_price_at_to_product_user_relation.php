<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceAtToProductUserRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_user_relation', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0.00)->change();
        });

        Schema::table('product_sku_relation', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_user_relation', function (Blueprint $table) {
            //
        });
    }
}
