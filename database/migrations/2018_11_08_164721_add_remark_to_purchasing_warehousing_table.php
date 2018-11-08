<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarkToPurchasingWarehousingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchasing_warehousing', function (Blueprint $table) {
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
        Schema::table('purchasing_warehousing', function (Blueprint $table) {
            //
        });
    }
}
