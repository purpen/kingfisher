<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_libraries', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0);
            $table->string('product_number',20);
            $table->string('name',50);
            $table->string('describe',100)->nullable();
            $table->string('path',100);
            $table->integer('size')->default(0);
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->string('mime',10);
            $table->string('domain',10);
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
        Schema::drop('material_libraries');
    }
}
