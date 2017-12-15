<?php
/**
 * 订单导入导出模版
 */
namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class OrderMould extends BaseModel
{
    protected $table = 'order_moulds';

    protected $fillable = ['name', 'user_id', 'type', 'kind', 'status', 'summary', 'outside_target_id', 'sku_number', 'sku_count', 'buyer_name', 'buyer_tel', 'buyer_phone', 'buyer_zip', 'buyer_province', 'buyer_city', 'buyer_county', 'buyer_township', 'buyer_address', 'buyer_summary', 'seller_summary', 'order_start_time', 'invoice_type', 'invoice_header', 'invoice_info', 'invoice_added_value_tax', 'invoice_ordinary_number', 'express_content', 'express_name', 'express_no', 'freight', 'discount_money'];

    //相对关联用户表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

}
