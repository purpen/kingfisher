<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
//    feedback 意见反馈表
//    字段	类型	空	默认值	注释
//    id	int(10)	否
//    user_id	int(10)	否		用户ID
//    content	varchar(500)	否		内容
//    contact	varchar(50)	是		联系方式
//    status	tinyint(4)	否	0	状态
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('content', 500);
            $table->string('contact', 50)->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('feedback');
    }
}
