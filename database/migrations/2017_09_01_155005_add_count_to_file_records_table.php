<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountToFileRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_records', function (Blueprint $table) {
            $table->integer('total_count')->default(0);
            $table->integer('success_count')->default(0);
            $table->integer('no_sku_count')->default(0);
            $table->integer('repeat_outside_count')->default(0);
            $table->integer('null_field_count')->default(0);
            $table->integer('sku_storage_quantity_count')->default(0);
            $table->string('no_sku_string',500)->nullable();
            $table->string('repeat_outside_string',500)->nullable();
            $table->string('null_field_string',500)->nullable();
            $table->string('sku_storage_quantity_string',500)->nullable();


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
            $table->dropColumn([
                'total_count',
                'no_sku_count',
                'success_count',
                'repeat_outside_count',
                'null_field_count',
                'sku_storage_quantity_count',
                'repeat_outside_string',
                'no_sku_string',
                'null_field_string',
                'sku_storage_quantity_string',
            ]);
        });
    }
}
