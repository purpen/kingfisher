<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarkToAllocationOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allocation_out', function (Blueprint $table) {
            $table->string('remark',100)->nullable(); //备注
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allocation_out', function (Blueprint $table) {
            //
        });
    }
}
