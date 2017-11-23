<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name', 30);
            $table->string('phone', 20);
            $table->string('email', 50)->nullable();
            $table->integer('province_id')->default(0);
            $table->integer('city_id')->default(0);
            $table->integer('county_id')->default(0);
            $table->integer('town_id')->default(0);
            $table->string('address', 100);
            $table->string('zip', 20)->nullable();
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->index('user_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('delivery_address');
    }
}
