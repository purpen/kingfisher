<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToDistributorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor', function (Blueprint $table) {
            $table->string('position',20);//职位
            $table->string('full_name',50);  //企业全称
            $table->string('legal_person',20);  //法人姓名
            $table->string('legal_phone',20);  //法人手机号
            $table->string('legal_number',20);  //法人身份证号
            $table->string('credit_code',20);  //统一社会信用代码
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributor', function (Blueprint $table) {
        });
    }
}
