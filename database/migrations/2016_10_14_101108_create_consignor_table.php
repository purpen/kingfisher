<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsignorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storage_id');
            $table->string('name',20);
            $table->string('origin_city',20);
            $table->string('tel',20)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('zip',10)->nullable();
            $table->integer('province_id');
            $table->integer('district_id');
            $table->string('address',500);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('consignor');
    }
}
