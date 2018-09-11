<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnterProvinceToDistributorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor', function (Blueprint $table) {
            $table->dropColumn('store_address', 'license_id', 'credit_code'); //删除多个字段
            $table->string('enter_phone',20);//企业电话
            $table->string('ein', 50);//税号
            $table->string('enter_province', 50);
            $table->string('enter_city', 50);
            $table->string('enter_county', 50);
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
            //
        });
    }
}
