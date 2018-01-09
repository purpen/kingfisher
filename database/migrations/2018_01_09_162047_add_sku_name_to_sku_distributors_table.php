<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkuNameToSkuDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sku_distributors', function (Blueprint $table) {
            $table->string('sku_name',50);
            $table->string('distributor_name',50);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sku_distributors', function (Blueprint $table) {
            $table->dropColumn(['distributor_name','sku_name']);
        });
    }
}
