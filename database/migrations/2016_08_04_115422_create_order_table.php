<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单表
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20);             //订单编号
            $table->string('outside_target_id',20);  //站外订单号
            $table->tinyInteger('type')->default(1); //类型：1.自营；2.淘宝；3.天猫；4.京东；5.--
            $table->integer('store_id');             //店铺ID
            $table->integer('user_id');              //用户ID
            $table->tinyInteger('payment_type')->default(1);  // 付款方式：1.在线；2. 货到付款
            $table->decimal('pay_money',10,2);             //支付金额
            $table->decimal('total_money',10,2);           //总金额
            $table->decimal('freight',10,2)->default(0);   //运费
            $table->decimal('discount_money',10,2);        //优惠金额
            $table->integer('express_id')->nullable();     //物流ID
            $table->string('express_no',20)->nullable();   //运单号
            $table->string('buyer_name',500)->nullable();  //收货人姓名
            $table->string('buyer_tel',20)->nullable();    //收货人电话
            $table->string('buyer_phone',20)->nullable();  //收货人手机
            $table->string('buyer_zip',8)->nullable();     //收货人邮编
            $table->string('buyer_address',200)->nullable();//收货人地址
            $table->string('buyer_summary',500)->nullable();  //买家备注
            $table->string('seller_summary',500)->nullable(); //卖家备注
            $table->string('summary',500)->nullable();        //备注
            $table->tinyInteger('status')->default(1);        //状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
            $table->dateTime('expired_time');                 //过期时间
            $table->tinyInteger('from_site')->default(1);     //设备来源: 1.Web；2.Wap；6.IOS；20.Android
            $table->tinyInteger('form_app')->default(0);      //应用来源：1.商城；2. Fiu*/
            $table->timestamps();
            $table->softDeletes();
        });

        //订单明细表
        Schema::create('order_sku_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('sku_id');
            $table->integer('product_id');
            $table->integer('quantity')->default(0);
            $table->decimal('price',10,2)->default(0);
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
        Schema::drop('order');
        Schema::drop('order_sku_relation');
    }
}
