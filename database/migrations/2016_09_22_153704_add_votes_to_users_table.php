<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->tinyInteger('platform');  //店铺平台
            $table->dateTime('authorize_overtime');  //key授权过期时间
            $table->string('access_token',100)->nullable();
            $table->string('refresh_token',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['platform', 'authorize_overtime','access_token','refresh_token']);
        });
    }
}
