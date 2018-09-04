<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceInformationToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->string('company_name',20);  //公司全称
            $table->string('company_phone',20);  //公司电话
            $table->string('opening_bank',20);  //开户行
            $table->string('bank_account',20);  //银行账户
            $table->string('unit_address',20);  //单位地址
            $table->string('duty_paragraph',20);  //税号
            $table->string('receiving_address',20);  //发票收件地址
            $table->string('receiving_name',20);  //发票收件人姓名
            $table->string('receiving_phone',20);  //发票收件人电话
            $table->integer('prove_id');//一般纳税人证明
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
}
