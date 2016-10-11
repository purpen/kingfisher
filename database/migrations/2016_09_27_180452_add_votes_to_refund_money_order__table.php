<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToRefundMoneyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refund_money_order', function (Blueprint $table) {
            $table->string('store_name',20);
            $table->string('out_order_id',20);
            $table->string('out_buyer_id',20);
            $table->string('out_buyer_name',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refund_money_order', function (Blueprint $table) {
            $table->dropColumn(['store_name','out_order_id','out_buyer_id','out_buyer_name']);
        });
    }
}
