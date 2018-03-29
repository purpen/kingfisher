<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrademarkIdToSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->integer('trademark_id')->default(0);
            $table->integer('power_of_attorney_id')->default(0);
            $table->integer('quality_inspection_report_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['trademark_id' , 'power_of_attorney_id' , 'quality_inspection_report_id']);
        });
    }
}
