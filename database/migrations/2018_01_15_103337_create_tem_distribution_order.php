<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemDistributionOrder extends Migration
{

/*id	int(10)	否
distribution_id	int(10)	否		分销商用户ID
outside_target_id	varchar(30)	否		站外订单号
sku_number	varchar(20)	否		sku编号
quantity	int(5)	是	0	数量
sku_name	varchar(50)	否		商品名 sku规格
price	decimal(10,2)	否	0	单价
buyer_name	varchar(500)	是		收货人姓名
buyer_tel	varchar(20)	是		收货人电话
buyer_phone	varchar(20)	是		收货人手机
buyer_zip	varchar(8)	是		收货人邮编
buyer_address	varchar(200)	是		收货人地址
buyer_province	varchar(20)	是		省
buyer_city	varchar(20)	是		市
buyer_county	varchar(20)	是		县
buyer_township	varchar(20)	是		镇
summary	varchar(500)	是		备注
buyer_summary	varchar(500)	是		买家备注
seller_summary	varchar(500)	是		卖家备注
order_start_time	datetime	否		下单时间
invoice_info	varchar(50)	否		发票内容
invoice_type	varchar(10)	否		发票类型
invoice_header	varchar(30)	否		发票抬头
invoice_added_value_tax	varchar(30)	否		增值税发票
invoice_ordinary_number	varchar(30)	否		普通发票号
discount_money	decimal(10,2)	否	0	优惠金额*/
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tem_distribution_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('distribution_id');
            $table->string('outside_target_id', 30);
            $table->string('sku_number', 20);
            $table->integer('quantity');
            $table->string('sku_name',50);
            $table->decimal('price', 10,2)->default(0.00);
            $table->string('buyer_name',50);
            $table->string('buyer_tel', 20)->default('');
            $table->string('buyer_phone', 20);
            $table->string('buyer_zip', 8)->default('');
            $table->string('buyer_address', 200);
            $table->string('buyer_province', 20)->default('');
            $table->string('buyer_city', 20)->default('');
            $table->string('buyer_county', 20)->default('');
            $table->string('buyer_township', 20)->default('');
            $table->string('summary', 500)->default('');
            $table->string('buyer_summary', 500)->default('');
            $table->string('seller_summary', 500)->default('');
            $table->dateTime('order_start_time');
            $table->string('invoice_info', 50)->default('');
            $table->string('invoice_type', 10)->default('');
            $table->string('invoice_header', 30)->default('');
            $table->string('invoice_added_value_tax', 30)->default('');
            $table->string('invoice_ordinary_number', 30)->default('');
            $table->decimal('discount_money', 10, 2)->default(0.00);
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
        Schema::drop('tem_distribution_order');
    }
}
