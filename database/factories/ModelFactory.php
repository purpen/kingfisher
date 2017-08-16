<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


//id	int(11)	否
//number	varchar(20)	否		订单编号
//outside_target_id	varchar(20)	否		站外订单号
//type	tinyint	否	1	类型：1.普通订单；2.渠道订单；3.下载订单；4.导入订单；5.众筹订单
//store_id	int	否		关联店铺ID
//user_id	int(11)	否		操作用户ID
//storage_id	int(11)	否		仓库ID
//payment_type	tinyint(1)	否	1	付款方式：1.在线；2. 货到付款 ;3.账期；4：月结；5：现结；
//pay_money	decimal(10,2)	否		支付金额
//total_money	decimal(10,2)	否		商品总金额
//count	int(11)	否		商品总数量
//freight	decimal(10,2)	否	0	运费
//discount_money	decimal(10,2)	否	0	优惠金额
//express_id	int(11)	是		物流ID
//express_no	varchar(20)	是		运单号
//buyer_name	varchar(500)	是		收货人姓名
//buyer_tel	varchar(20)	是		收货人电话
//buyer_phone	varchar(20)	是		收货人手机
//buyer_zip	varchar(8)	是		收货人邮编
//buyer_address	varchar(200)	是		收货人地址
//buyer_province	varchar(20)	是		省
//buyer_city	varchar(20)	是		市
//buyer_county	varchar(20)	是		县
//buyer_township	varchar(20)	是		镇
//buyer_summary	varchar(500)	是		买家备注
//seller_summary	varchar(500)	是		卖家备注
//order_start_time	datetime	是		下单时间
//order_verified_time	datetime	是		审核时间
//verified_user_id	int(11)	是		审核人ID
//order_send_time	detetime	是		发货时间
//send_user_id	int(11)	是		发货人ID
//invoice_info	varchar(50)	否		发票信息
//summary	varchar(500)	是		备注
//status	tinyint(1)	否	1	状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
//suspend	tinyint(1)	否	0	状态：0.正常；1.挂起；
//expired_time	datetime	否		过期时间
//from_site	tinyint(1)	否	1	设备来源: 1.web;6.wap;7.ios;8.android;
//from_app	tinyint(1)	否	0	应用来源：1.商城；2. Fiu
//pec	varchar(25)	是		个人推荐码
//order_user_id	int(11)	否	0	会员ID
//user_id_sales	int(11)	否	0	关联销售人员用户ID
//is_vop	tinyint(1)	否	0	否开普勒订单
//jd_order_id	varchar(20)	是		开普勒订单号
//received_money	decimal(10,2)	否	0	已收款金额

// 订单模型工场
$factory->define(App\Models\OrderModel::class, function (Faker\Generator $faker) {

//    $faker = Faker\Factory::create('zh_CN');

    $cities = config('constant.city');
    $province = $cities[array_rand($cities, 1)];
    return [
        'number' => mt_rand(100000000, 999999999),
        'outside_target_id' => mt_rand(100000000, 999999999),
        'type' => 4,
        'store_id' => 1,
        'user_id' => 1,
        'storage_id' => 1,
        'payment_type' => 1,
        'count' => 1,
        'freight' => 0,
        'discount_money' => 0,
        'express_id' =>1,
        'express_no' => mt_rand(100000000, 999999999),
        'buyer_name' => $faker->name,
        'buyer_tel' => $faker->phoneNumber,
        'buyer_phone' => mt_rand(10000,99999),
        'buyer_address' => $faker->address,
        'buyer_province' => $province,
        'buyer_city' => $faker->city,
        'buyer_county' => $faker->streetName,
        'order_start_time' => date("Y-m-d H:i:s", time() - (mt_rand(1,30)* 24*3600)),
        'order_verified_time' => date("Y-m-d H:i:s", time() - (mt_rand(1,30)* 24*3600)),
        'verified_user_id' => 1,
        'invoice_info' => '',
        'status' => 20,

        'pay_money' => 0,
        'total_money' => 0,
        'received_money' => 0,
    ];
});


//id	int(11)	否
//order_id	int(11)	否		订单ID
//sku_id	int(11)	否		skuID
//sku_number	varchar(20)	否		sku编号
//sku_name	varchar(50)	否		平台返回商品名 sku规格
//product_id	int(11)	否		商品ID
//quantity	int(5)	是	0	数量
//price	decimal(10,2)	否	0	单价
//discount	decimal(10,2)	否	0	优惠金额
//status	tinyint(1)	否	0	0：默认，1；赠品
//refund_status	tinyint(1)	否	0	0:默认,1:已退款2:已退货3:已返修
//out_storage_id	varchar(20)	是		(自营平台)来自店铺ID
//vop_id	varchar(20)	是		开普勒skuID

//订单详情模型工场
$factory->define(App\Models\OrderSkuRelationModel::class, function (Faker\Generator $faker) {

    $suk_count = \App\Models\ProductsSkuModel::count();
    $sku_id = mt_rand(1, $suk_count);
    $sku_model = \App\Models\ProductsSkuModel::find($sku_id);
    $price = $sku_model->price;
    return [
        'sku_id' => $sku_id,
        'sku_number' => $sku_model->number,
        'sku_name' => $sku_model->mode,
        'quantity' => 1,
        'price' => $price,
        'discount' => 0,
        'status' => 0,
        'refund_status' => 0,
        'order_id' => function (array $ProductsSkuModel) {
            return factory(App\Models\OrderModel::class)->create([
                'pay_money' => $ProductsSkuModel['price'],
                'total_money' => $ProductsSkuModel['price'],
                'received_money' => $ProductsSkuModel['price'],
            ])->id;
        }
    ];
});