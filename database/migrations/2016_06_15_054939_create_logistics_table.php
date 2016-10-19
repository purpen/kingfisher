<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);  //公司名称
            $table->string('area',50)->nullable();  //所属子公司（区域）
            $table->string('contact_user',15);  //联系人
            $table->string('contact_number',15);  //联系电话
            $table->integer('user_id');
            $table->tinyInteger('status')->default(1);  //状态：0.禁用；1.正常
            $table->string('summary',500);  //备注
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
        Schema::drop('logistics');
    }
}
