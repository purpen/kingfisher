<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCityToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignor', function (Blueprint $table) {
            $table->dropColumn(['province_id', 'district_id']);
            $table->string('province',20);
            $table->string('city',20);
            $table->string('district',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consignor', function (Blueprint $table) {
            $table->dropColumn(['province', 'city', 'district']);
        });
    }
}
