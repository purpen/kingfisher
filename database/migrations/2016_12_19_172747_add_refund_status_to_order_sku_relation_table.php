<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefundStatusToOrderSkuRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_sku_relation', function (Blueprint $table) {
            $table->tinyInteger('refund_status')->default(0);
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
            $table->dropColumn(['refund_status']);
        });
    }
}
