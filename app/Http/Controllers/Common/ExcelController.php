<?php

namespace App\Http\Controllers\Common;

use App\Models\OrderModel;
use App\Models\PaymentAccountModel;
use App\Models\PaymentOrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * 使用订单ID 导出订单（excel格式）
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
        $data = $this->orderSelect()->whereIn('id',$id_array)->get();
        
        //构造数据
        $data = $this->createData($data);
        
        //导出Excel表单
        $this->createExcel($data,'订单');
    }

    /**
     * 导出订单查询条件
     */
    public function orderSelect()
    {
        $orderObj = OrderModel::select([
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

        return $orderObj;
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
     * 生成导出的excel表单
     * @param $data 数据
     * @param string $message 名称
     */
    protected function createExcel($data, $message='表单')
    {
        $message = strval($message);
        //生成excel表单
        Excel::create($message,function($excel) use($data){
            $excel->sheet('1',function ($sheet) use($data){
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }



    /**
     * 导入订单Excel文件
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|string
     */
    public function inFile(Request $request){
        if(!$request->hasFile('file') || !$request->file('file')->isValid()){
            return '上传失败';
        }
        $file = $request->file('file');

        //读取execl文件
        $results = Excel::load($file, function($reader) {
        })->get();

        $results = $results->toArray();

        DB::beginTransaction();
        foreach ($results as $data){
            $result = OrderModel::inOrder($data);
            if(!$result[0]){
                DB::rollBack();
                return view('errors.200',['message' => $result[1], 'back_url' => '/order']);
            }
        }
        DB::commit();

        return redirect('/order');
    }


    /**
     * 付款单列表查询条件
     */
    protected function paymentSelect()
    {
        $paymentObj = PaymentOrderModel
            ::select(['receive_user as 收款人','amount as 付款金额', 'payment_account_id', 'payment_time as 付款时间', 'type', 'summary as 备注']);
        return $paymentObj;
    }

    /**
     * 构造付款单execl数据
     */
    protected function createPaymentData($data)
    {
        foreach ($data as $v){
            if($v->payment_account_id){
                $payAcc = PaymentAccountModel::find($v->payment_account_id);
                if($payAcc){
                    $v->付款账号 = $payAcc->account . ':' . $payAcc->bank;
                }
            }else{
                $v->付款账号 = '';
            }
            if($v->type){
                $v->类型 = $v->type_val;
            }
            unset($v->payment_account_id,$v->type);
        }

        return $data;
    }

    public function paymentList(Request $request)
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
        $data = $this->paymentSelect()->whereIn('id',$id_array)->get();

        //构造数据
        $data = $this->createPaymentData($data);

        //导出Excel表单
        $this->createExcel($data,'付款单');
    }

}
