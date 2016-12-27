<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTelToOrderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_users', function (Blueprint $table) {
            $table->string('tel',20);
            $table->string('zip',20);
            $table->string('buyer_township',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_users', function (Blueprint $table) {
            $table->dropColumn(['tel','zip','buyer_township']);
        });
    }
}
