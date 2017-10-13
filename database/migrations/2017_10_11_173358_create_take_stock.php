<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakeStock extends Migration
{
    /*storage_id	int(10)	否		仓库ID
    status	tinyint(4)	否		状态：0.进行中；1.盘点完毕
    summary	varchar(500)	是		盘点备注
    log	varchar(500)	是		变更记录
    user_id	int(10)	否		操作人员ID*/

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('take_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storage_id');
            $table->tinyInteger('status')->default(0);
            $table->string('summary', 500)->default('');
            $table->string('log', 500)->default('');
            $table->integer('user_id');
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
        Schema::drop('take_stock');
    }
}
