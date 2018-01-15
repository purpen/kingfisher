<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductUnopenedToFileRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_records', function (Blueprint $table) {
            $table->string('product_unopened_string',1000);
            $table->integer('product_unopened_count');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_records', function (Blueprint $table) {
            $table->dropColumn(['product_unopened_string' , 'product_unopened_count']);
        });
    }
}
