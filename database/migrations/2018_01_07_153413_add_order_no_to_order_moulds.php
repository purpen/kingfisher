<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderNoToOrderMoulds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_moulds', function (Blueprint $table) {
            $table->integer('order_no')->default(0);
            $table->integer('outside_sku_number')->default(0);
            $table->integer('sku_name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_moulds', function (Blueprint $table) {
            $table->dropColumn(['order_no','outside_sku_number','sku_name']);
        });
    }
}
