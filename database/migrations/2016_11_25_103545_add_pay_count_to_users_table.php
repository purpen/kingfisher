<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayCountToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_sku', function (Blueprint $table) {
            $table->integer('reserve_count')->default(0);
            $table->integer('pay_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_sku', function (Blueprint $table) {
            $table->dropColumn(['reserve_count','pay_count']);
        });
    }
}
