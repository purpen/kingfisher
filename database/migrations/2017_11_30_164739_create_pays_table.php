<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid',20)->unique();
            $table->integer('user_id')->default(0);
            $table->tinyInteger('pay_type');
            $table->integer('order_id')->default(0);
            $table->tinyInteger('bank_id');
            $table->tinyInteger('status')->default(0);
            $table->string('summary',100)->default('');
            $table->string('pay_no',30)->default('');
            $table->decimal('amount' , 10 ,2);
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
        Schema::drop('pays');
    }
}
