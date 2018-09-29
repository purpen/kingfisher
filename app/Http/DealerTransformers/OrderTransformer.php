<?php

namespace App\Http\DealerTransformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(OrderModel $orders)
    {
        $price_sku =$orders->orderSkuRelation;
//        $address = $orders->address_list;
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
            'express' => $orders->logistics?$orders->logistics->name:'',
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
            'is_voucher' => $orders->is_voucher,
            'orderSku' => $orders->order_skus,

            'phone' => $orders->buyer_phone?$orders->buyer_phone:'',
            'name' => $orders->buyer_name?$orders->buyer_name:'',
            'province' => $orders->province?$orders->province:'',
            'city' => $orders->city?$orders->city:'',
            'county' => $orders->county?$orders->county:'',
            'town' => $orders->town?$orders->town:'',
            'address' => $orders->buyer_address?$orders->buyer_address:'',
        ];
    }
}
