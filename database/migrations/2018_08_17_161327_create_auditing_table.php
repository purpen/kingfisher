<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');//用户id
            $table->tinyInteger('type');//审核模块名称
            $table->tinyInteger('status')->default(1);//状态：0.禁用；1.正常
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
        Schema::drop('auditing');
    }
}
