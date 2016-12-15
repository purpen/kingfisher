<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership', function (Blueprint $table)
        {
            $table->increments('id');
            
            $table->integer('user_id')->default(0);
            $table->string('account', 30)->unique()->nullable();
            $table->string('username', 30);
            $table->string('email', 30)->nullable();
            $table->string('phone', 20);
            $table->integer('sex')->default(0);
            $table->string('qq', 20)->nullable();
            $table->string('ww', 20)->nullable();
            
            // 会员来源：1.自营；2.京东；3.淘宝；4.--
            $table->tinyInteger('from_to')->default(0);
            
            $table->tinyInteger('type')->default(1);
            $table->integer('store_id')->default(1);
            $table->integer('level')->default(1);
            
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
        Schema::drop('membership');
    }
}
