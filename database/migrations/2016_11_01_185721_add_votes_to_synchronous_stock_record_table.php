<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToSynchronousStockRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('synchronous_stock_record', function (Blueprint $table) {
            $table->dateTime('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('synchronous_stock_record', function (Blueprint $table) {
            $table->dropColumn(['end_tiem']);
        });
    }
}
