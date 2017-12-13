<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChannelIdToOrderSkuRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_sku_relation', function (Blueprint $table) {
            $table->integer('channel_id')->default(0);

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
            $table->dropColumn('channel_id');
        });
    }
}
