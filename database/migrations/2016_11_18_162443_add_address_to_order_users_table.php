<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToOrderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->string('buyer_address',200)->nullable();
            $table->string('buyer_province',20)->nullable();
            $table->string('buyer_city',20)->nullable();
            $table->string('buyer_county',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->dropColumn(['buyer_address' , 'buyer_province' , 'buyer_city' , 'buyer_county']);
        });
    }
}
