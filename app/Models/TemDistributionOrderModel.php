<?php

namespace App\Models;

class TemDistributionOrderModel extends BaseModel
{

    protected $table = 'tem_distribution_order';

    protected $fillable = [
        'distribution_id', 'outside_target_id', 'sku_number', 'quantity', 'sku_name' . 'price', 'buyer_name', 'buyer_tel', 'buyer_phone', 'buyer_zip', 'buyer_address', 'buyer_province', 'buyer_city', 'buyer_county', 'buyer_township', 'summary', 'buyer_summary', 'seller_summary', 'order_start_time', 'invoice_info', 'invoice_type', 'invoice_header', 'invoice_added_value_tax', 'invoice_ordinary_number', 'discount_money'];

}