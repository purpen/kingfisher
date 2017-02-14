<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentToReturnedPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //采退单
        Schema::table('returned_purchases', function (Blueprint $table){
            $table->tinyInteger('department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //采退单
        Schema::table('returned_purchases', function (Blueprint $table) {
            $table->dropColumn(['department']);
        });
    }
}
