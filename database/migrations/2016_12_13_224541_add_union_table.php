<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unions', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id')->default(0);
            
            // 推广码
            $table->string('pecode', 10);
            
            // 机构 or 个人
            $table->tinyInteger('type')->default(0);
            // 总额
            $table->double('total_amount', 15, 2);
            // 申请提现，待支付的金额
            $table->double('topay_amount', 15, 2);
            
            $table->string('name', 50);
            $table->string('idcard', 25);
            $table->string('phone', 11);
            $table->string('email');
            
            // 收款信息
            $table->string('bank_user', 50);
            $table->string('bank_account', 25);
            $table->string('bank_name', 20);
            // 开户行及支行
            $table->string('bank_branch');
            
            // 用户状态
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
        Schema::drop('unions');
    }
}
