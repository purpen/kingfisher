<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->string('invoice_type',10);
            $table->string('invoice_header',30);
            $table->string('invoice_added_value_tax',30);
            $table->string('invoice_ordinary_number',30);

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
            $table->dropColumn([
                'invoice_type',
                'invoice_header',
                'invoice_added_value_tax',
                'invoice_ordinary_number',
            ]);
        });
    }
}
