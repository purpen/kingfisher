<?php

namespace App\Http\DealerTransformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(OrderModel $orders)
    {
        $price_sku =$orders->orderSkuRelation;
        $address = $orders->address_list;
//        $province = $city = $county = $town = '';
//        if ($address->province) $province = $address->province->name;
//        if ($address->city) $city = $address->city->name;
//        if ($address->county) $county = $address->county->name;
//        if ($address->town) $town = $address->town->name;
        return [
            'id' => (int)$orders->id,
            'number' => $orders->number,
            'pay_money' => $orders->pay_money,
            'user_id' => (int)$orders->user_id,
            'count' => (int)$orders->count,
            'express_no' => $orders->express_no,
            'express_id' => (int)$orders->express_id,
            'order_start_time' =>$orders->order_start_time,
            'status' => (int)$orders->status,
            'status_val' => $orders->status_val,
            'freight' => $orders->freight,
            'user_id_sales' => (int)$orders->user_id_sales,
            'payment_type' => $orders->payment_type,
            'receiving_id' => $orders->receiving_id,
            'company_name' => $orders->company_name,
            'invoice_value' => $orders->invoice_value,
            'over_time' => $orders->over_time,
            'orderSku' => $orders->order_skus,

            'phone' => $address->phone?$address->phone:$orders->buyer_phone,
            'name' => $address->name?$address->name:$orders->buyer_name,
            'fixed_telephone' => $address->fixed_telephone?$address->fixed_telephone:'',
            'province_id' => $address->province_id?$address->province_id:$orders->buyer_province,
            'province' => $orders->province?$orders->province:'',
            'city_id' => $address->city_id?$address->city_id:$orders->buyer_city,
            'city' => $orders->city?$orders->city:'',
            'county_id' => $address->county_id?$address->county_id:$orders->buyer_county,
            'county' => $orders->county?$orders->county:'',
            'town_id' => $address->town_id?$address->town_id:$orders->buyer_township,
            'town' => $orders->town?$orders->town:'',
            'address' => $address->address?$address->address:$orders->buyer_address,
        ];
    }
}
