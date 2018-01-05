<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_distributors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku_number',30);
            $table->integer('distributor_id')->default(0);
            $table->string('distributor_number',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sku_distributors');
    }
}
