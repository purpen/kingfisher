<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('target_id')->index();
            $table->string('target_model_name',50);           //模型类名
            $table->tinyInteger('evt')->default(1)->index();  //	行为：1.创建；2.编辑；3.删除；4.－－；
            $table->tinyInteger('type')->default(1)->index();  // Model类型：1.用户；2.仓库；3.分类；4.
            $table->string('remark',500);  //备注
            $table->tinyInteger('status')->default(1);  // 状态
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
        // 删除records 表
        Schema::drop('records');
    }
}
