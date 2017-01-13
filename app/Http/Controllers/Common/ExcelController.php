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
    //查询select 条件对象
    protected $obj = null;
    
    public function __construct()
    {
        $this->obj = OrderModel::select([
            'number as 订单编号',
            'order_start_time as 下单时间',
            'count as 商品数量',
            'pay_money as 付款金额',
            'freight as 邮费',
            'id',
            'buyer_name as 买家名',
            'buyer_address as 收货地址',
            'buyer_summary as 买家备注',
            'store_id',
            'express_id',
            'express_no as 快递单号',
        ]);
    }
    /**
     * 使用订单ID 导出订单excel格式
     */
    public function orderList(Request $request)
    {
        //需要下载的订单 id数组
        $all = $request->all();
        $id_array = [];
        foreach ($all as $k => $v){
            if(is_int($k)){
                $id_array[] = $v;
            }
        }
        
        //查询订单数据集合
        $data = $this->obj->whereIn('id',$id_array)->get();
        
        //构造数据
        $data = $this->createData($data);
        
        //导出Excel表单
        $this->createExcel($data);
    }
    
    
    /**
     * 根据查询的数据对象 构造Excel数据
     * 
     * @param OrderModel $option 查询where条件
     */
    protected function createData($data)
    {
        //组织Excel数据
        foreach ($data as $v){
            if($v->logistics){
                $v->物流 = $v->logistics->name;
            }else{
                $v->物流 = '';
            }

            if($v->store){
                $v->店铺名称 = $v->store->name;
            }else{
                $v->店铺名称 = '';
            }

            //拼接订单详情内容
            $sku_info = '';
            foreach ($v->orderSkuRelation as $s){
                $sku_info = $sku_info  .  $s->sku_name . '*' . $s->quantity . ';';
            }
            $v->明细 = $sku_info;

            unset($v->store_id,$v->express_id,$v->id,$v->change_status);

        }
        
        return $data;
    }
    
    /**
     * 生成导出订单
     * @param $data
     */
    protected function createExcel($data)
    {
        //生成excel表单
        Excel::create('订单列表',function($excel) use($data){
            $excel->sheet('订单列表',function ($sheet) use($data){
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }

}
