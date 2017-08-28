<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_record', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mark',30);
            $table->string('url',30);
            $table->tinyInteger('site_type')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('count');
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
        Schema::drop('site_record');
    }
}
