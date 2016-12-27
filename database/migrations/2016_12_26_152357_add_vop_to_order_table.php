<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVopToOrderTable extends Migration
{
    /*
     is_vop	tinyint(1)	否	0	否开普勒订单
     jd_order_id	varchar(20)	是		开普勒订单号*/
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->tinyInteger('is_vop')->default(0);
            $table->string('jd_order_id')->default('');
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
            $table->dropColumn(['is_vop','jd_order_id']);
        });
    }
}
