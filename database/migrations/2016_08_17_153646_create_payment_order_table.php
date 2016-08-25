<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);
            $table->string('receive_user',20);
            $table->decimal('amount',10,2);
            $table->integer('payment_account_id');
            $table->tinyInteger('type')->default(1);
            $table->integer('target_id');
            $table->integer('user_id');
            $table->string('summary',500);
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('payment_order');
    }
}
