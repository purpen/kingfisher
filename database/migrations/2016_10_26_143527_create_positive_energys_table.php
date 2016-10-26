<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositiveEnergysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positive_energys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content','50');//内容
            $table->tinyInteger('type')->default(1);//时间状态　1.早晨；2.上午；3.下午；４.晚上
            $table->tinyInteger('sex')->default(1);//状态 1.男 0.女
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
        Schema::drop('positive_energys');
    }
}
