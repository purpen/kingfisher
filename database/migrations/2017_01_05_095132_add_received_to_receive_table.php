<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReceivedToReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receive_order', function (Blueprint $table) {
            $table->decimal('received_money',10,2)->default(0);
        });

        Schema::table('order', function (Blueprint $table) {
            $table->decimal('received_money',10,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receive_order', function (Blueprint $table) {
            $table->dropColumn(['received_money']);
        });

        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn(['received_money']);
        });
    }
}
