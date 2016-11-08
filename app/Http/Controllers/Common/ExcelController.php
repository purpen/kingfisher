<?php

namespace App\Http\Controllers\Common;

use App\Models\OrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * 导出订单excel格式
     */
    public function orderList(Request $request)
    {
        $status = $request->input('status');
        /*1.待付款；5.待审核；8.待发货；*/
        if(!in_array($status, [1,5,8,10])){
            return view('errors.403');
        }

        //使用$status和日期生成缓存的key
        $key = $status . 'excel' . date("Ymd");

        //判断是否存在缓存数据
        if (!Cache::has($key)){
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
            ])->where('status',$status)->get();

            //组织Excel输入数据
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

            //设置缓存 有效期为一天
            $time = Carbon::now()->addDay();
            Cache::put($key,$data,$time);
        }else{
            $data = Cache::get($key);
        }



        //生成excel表单
        Excel::create('订单列表',function($excel) use($data){
            $excel->sheet('订单列表',function ($sheet) use($data){
                $sheet->fromArray($data);
            });
        })->export('xls');
    }
}
