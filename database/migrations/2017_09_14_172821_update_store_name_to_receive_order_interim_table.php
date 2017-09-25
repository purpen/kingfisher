<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreNameToReceiveOrderInterimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receive_order_interim', function (Blueprint $table) {
            $table->renameColumn('store_name', 'department_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receive_order_interim', function (Blueprint $table) {
            $table->renameColumn('department_name','store_name');

        });
    }
}
