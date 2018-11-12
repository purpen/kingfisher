<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkuIdToSkuUniqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sku_unique', function (Blueprint $table) {
            //
            $table->index(['sku_id','storage_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sku_unique', function (Blueprint $table) {
            //
        });
    }
}
