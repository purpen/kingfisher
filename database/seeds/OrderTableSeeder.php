<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\Models\OrderSkuRelationModel::class)->create();

        $faker = Faker\Factory::create('zh_CN');

        $suk_count = \App\Models\ProductsSkuModel::count();
        $user_id_array = \App\Models\UserModel::where(['type' => 1])->get()->pluck('id')->toArray();
//        dd($user_id_array);

        for ($i = 0; $i < 5000; $i++) {

            $sku_id = mt_rand(1, $suk_count);
            $sku_model = \App\Models\ProductsSkuModel::find($sku_id);
            if (!$sku_model) {
                continue;
            }
            $price = $sku_model->price;


            $cities = config('constant.city');
            $province = $cities[array_rand($cities, 1)];
            $order = [
                'number' => mt_rand(100000000, 999999999),
                'outside_target_id' => mt_rand(100000000, 999999999),
                'type' => 6,
                'store_id' => 1,
                'user_id' => $user_id_array[array_rand($user_id_array)],
                'storage_id' => 1,
                'payment_type' => 1,
                'count' => 1,
                'freight' => 0,
                'discount_money' => 0,
                'express_id' => 1,
                'express_no' => mt_rand(100000000, 999999999),
                'buyer_name' => $faker->name,
                'buyer_tel' => $faker->phoneNumber,
                'buyer_phone' => mt_rand(10000, 99999),
                'buyer_address' => $faker->address,
                'buyer_province' => $province,
                'buyer_city' => $faker->city,
                'buyer_county' => $faker->streetName,
                'order_start_time' => date("Y-m-d H:i:s", time() - mt_rand(1, 30 * 24 * 3600)),
                'order_verified_time' => date("Y-m-d H:i:s", time() - mt_rand(1, 30 * 24 * 3600)),
                'verified_user_id' => 1,
                'invoice_info' => '',
                'status' => 20,

                'pay_money' => $price,
                'total_money' => $price,
                'received_money' => $price,
            ];

            $order_model = \App\Models\OrderModel::create($order);

            $sku_array = [
                'sku_id' => $sku_id,
                'sku_number' => $sku_model->number,
                'sku_name' => $sku_model->mode,
                'quantity' => 1,
                'price' => $price,
                'discount' => 0,
                'status' => 0,
                'refund_status' => 0,
                'order_id' => $order_model->id,
            ];

            \App\Models\OrderSkuRelationModel::create($sku_array);
        }
    }
}
