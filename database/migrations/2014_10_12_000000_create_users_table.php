<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account',20)->unique();
            $table->string('email',50)->unique()->nullable();
            $table->string('phone',11)->unique();
            $table->string('password', 60);
            $table->string('realname',20)->nullable();
            $table->tinyInteger('position');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('sex')->default(0);//状态 1.男 0.女
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
