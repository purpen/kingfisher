<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHistoryInvoiceUnitAddressToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_invoice', function (Blueprint $table) {
            //
            $table->string('unit_address', 50)->change();
            $table->string('receiving_address', 50)->change();
            $table->string('bank_account', 50)->change();
            $table->string('company_name', 50)->change();
            $table->string('receiving_name', 30)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_invoice', function (Blueprint $table) {
            //
        });
    }
}
