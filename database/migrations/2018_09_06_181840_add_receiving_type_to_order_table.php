<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReceivingTypeToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('company_name', 'company_phone', 'opening_bank','bank_account','unit_address','duty_paragraph','receiving_address','receiving_name','receiving_phone','prove_id','invoice_value','application_time'); //删除多个字段,
            $table->integer('receiving_id');//发票id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
}
