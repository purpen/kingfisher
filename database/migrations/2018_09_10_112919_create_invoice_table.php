<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');  //用户id
            $table->string('company_name',20);  //公司全称
            $table->string('company_phone',20);  //公司电话
            $table->string('reviewer',50); //审核人
            $table->dateTime('audit');//审核时间
            $table->dateTime('apply');//申请时间
            $table->string('opening_bank',20);  //开户行
            $table->string('bank_account',20);  //银行账户
            $table->string('unit_address',20);  //单位地址
            $table->string('duty_paragraph',20);  //税号
            $table->string('receiving_address',20);  //发票收件地址
            $table->string('receiving_name',20);  //发票收件人姓名
            $table->string('receiving_phone',20);  //发票收件人电话
            $table->string('invoice_value',20);  //发票金额
            $table->integer('prove_id')->nullable();//一般纳税人证明
            $table->integer('receiving_id');//发票类型 0.不开票 1.普通发票 2.专票
            $table->string('reason', 50);//拒绝原因
            $table->integer('receiving_type');//开发票的状态 1.未开票 2.审核中 3.已开票. 4.拒绝
            $table->dateTime('application_time');//发票申请时间
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
        //
        Schema::drop('invoice');
    }
}
