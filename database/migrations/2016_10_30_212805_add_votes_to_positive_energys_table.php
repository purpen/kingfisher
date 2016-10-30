<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToPositiveEnergysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('positive_energys', function (Blueprint $table) {
            $table->tinyInteger('sex')->default(0);//状态 1.男 0.女

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('positive_energys', function (Blueprint $table) {
            $table->dropColumn('sex');//状态 1.男 0.女
        });
    }
}
