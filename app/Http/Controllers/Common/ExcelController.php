<?php

namespace App\Http\Controllers\Common;

use App\Models\OrderModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * 导出订单excel格式
     */
    public function orderList()
    {
        $data = OrderModel::select([
            'number as 订单编号',
            'order_start_time as 下单时间',
            'buyer_name as 买家名',
            'buyer_summary as 买家备注',
            'express_no as 快递单号',
            'count as 商品数量',
            'pay_money as 付款金额',
            'freight as 邮费',
            'store_id',
            'express_id',
            'id',
            'buyer_address as 收货地址'
        ])->where('status',5)->get();
        foreach ($data as $v){
            if($v->store){
                $v->店铺名称 = $v->store->name;
            }else{
                $v->店铺名称 = '';
            }

            if($v->logistics){
                $v->物流 = $v->logistics->name;
            }else{
                $v->物流 = '';
            }

            //拼接订单详情
            $sku_info = '';
            foreach ($v->orderSkuRelation as $s){
                $sku_info = $sku_info  .  $s->sku_name . '*' . $s->quantity . ';';
            }
            $v->明细 = $sku_info;

            unset($v->store_id,$v->express_id,$v->id);

        }
        Excel::create('订单列表',function($excel) use($data){
            $excel->sheet('订单列表',function ($sheet) use($data){
                $sheet->fromArray($data);
            });
        })->export('xls');
    }
}
