<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributorPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('distributor_user_id');
            $table->integer('user_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('price',10,2);
            $table->tinyInteger('status')->default(0);//0.默认 1.待负责人确认 2.待分销商确认 3. 待确认收款 4.完成
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
        Schema::drop('distributor_payment');
    }
}
