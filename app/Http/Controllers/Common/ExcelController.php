<?php

namespace App\Http\Controllers\Common;

use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\PaymentAccountModel;
use App\Models\PaymentOrderModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\purchasesInterimModel;
use App\Models\receiveOrderInterimModel;
use App\Models\ReceiveOrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    /**
     * 导出付款单（excel格式）
     *
     * @param Request $request
     */
    public function paymentList(Request $request)
    {
        //需要下载的付款单 id数组
        $all = $request->all();
        $id_array = [];
        foreach ($all as $k => $v){
            if(is_int($k)){
                $id_array[] = $v;
            }
        }

        //查询付款单数据集合
        $data = $this->paymentSelect()->whereIn('id',$id_array)->get();

        //构造数据
        $data = $this->createPaymentData($data);

        //导出Excel表单
        $this->createExcel($data,'付款单');
    }

    /**
     *按时间、类型导出付款单
     *
     * @param Request $request
     */
    public function dateGetPayment(Request $request)
    {
        $type = (int)$request->input('payment_type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $subnav = $request->input('subnav');

        $start_date = date("Y-m-d H:i:s",strtotime($start_date));
        $end_date = date("Y-m-d H:i:s",strtotime($end_date));

        if($subnav === 'waitpay'){
            $status = 0;
        }else if($subnav === 'finishpay'){
            $status = 1;
        }
        //查询付款单数据集合
        $query = $this->paymentSelect()->where('status',$status);
        if($type){
            $query->where('type',$type);
        }
        $data = $query->whereBetween('created_at', [$start_date, $end_date])->get();
        //构造数据
        $data = $this->createPaymentData($data);

        //导出Excel表单
        $this->createExcel($data,'付款单');
    }
    
    /**
     * 众筹导入Excel
     */
    public function zcInFile(Request $request)
    {
        $store_id = $request->input('store_id');
        $product_id = $request->input('product_id');
        $user_id = Auth::user()->id;
        Log::info($product_id);
        if(empty($store_id)){
            return '店铺不能为空';

        }
        if(empty($product_id)){
            return '商品不能为空';

        }
        $product = ProductsModel::where('id' , $product_id)->first();
        $product_number = $product->number;
        if(!$request->hasFile('zcFile') || !$request->file('zcFile')->isValid()){
            return '上传失败';
        }
        $file = $request->file('zcFile');

        //读取execl文件
        $results = Excel::load($file, function($reader) {
        })->get();

        $results = $results->toArray();
        DB::beginTransaction();
        $new_data = [];

        foreach ($results as $data){
            if(!empty($data['档位价格']) && !in_array($data['档位价格'] , $new_data)){
                $sku_number  = 1;
                $sku_number .= date('ymd');
                $sku_number .= sprintf("%05d", rand(1,99999));
                $product_sku = new ProductsSkuModel();
                $product_sku->product_id = $product_id;
                $product_sku->product_number = $product_number;
                $product_sku->number = $sku_number;
                $product_sku->price = $data['档位价格'];
                $product_sku->bid_price = $data['档位价格'];
                $product_sku->cost_price = $data['档位价格'];
                $product_sku->mode = '众筹款';
                $product_sku->save();
                $product_sku_id = $product_sku->id;
                $new_data[] = $product_sku->price;
            }else{
                $product_sku = ProductsSkuModel::where('price' , $data['档位价格'])->where('mode' , '众筹款')->first();
                $product_sku_id = $product_sku->id;
            }
            $result = OrderModel::zcInOrder($data , $store_id , $product_id , $product_sku_id , $user_id);
            if(!$result[0]){
                DB::rollBack();
                return view('errors.200',['message' => $result[1], 'back_url' => '/order']);
            }
        }
        DB::commit();

        return redirect('/order');
    }

    /**
     * 联系人excl
     */
    public function contactsInExcel(Request $request){
        if(!$request->hasFile('contactsFile') || !$request->file('contactsFile')->isValid()){
            return '上传失败';
        }
        $file = $request->file('contactsFile');

        //读取execl文件
        $results = Excel::load($file, function($reader) {
        })->get();

        $results = $results->toArray();

        DB::beginTransaction();
        foreach ($results as $data){
            $result = OrderModel::contactsInOrder($data);
            if(!$result[0]){
                DB::rollBack();
                return view('errors.200',['message' => $result[1], 'back_url' => '/order']);
            }
        }
        DB::commit();

        return redirect('/order');
    }

    /**
     * 收款单列表查询条件
     */
    protected function receiveSelect()
    {
        $receiveObj = receiveOrderInterimModel
            ::select([
                'department_name as 销售主体',
                'product_title as 销售产品',
                'supplier_name as 品牌',
                'order_type as 销售模式',
                'buyer_name as 客户名称',
                'order_start_time as 销售时间',
                'quantity as 销售数量',
                'price as 销售金额',
                'cost_price as 成本金额',
                'invoice_start_time as 开票时间',
                'total_money as 开票金额',
                'receive_time as 收款时间',
                'amount as 	收款金额',
            ]);
        return $receiveObj;
    }

    /**
     *按时间、类型导出收款单
     *
     */
    public function dateGetReceive(Request $request)
    {
        $type = (int)$request->input('type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start_date = date("Y-m-d H:i:s",strtotime($start_date));
        $end_date = date("Y-m-d H:i:s",strtotime($end_date));

        //查询付款单数据集合
        $query = $this->receiveSelect();
        if($type){
            $query->where('type',$type);
        }
        $data = $query->whereBetween('receive_time', [$start_date, $end_date])->get();

        //导出Excel表单
        $this->createExcel($data,'收入明细');
    }

    /**
     * 采购单列表查询条件
     */
    protected function purchasesSelect()
    {
        $purchasesObj = purchasesInterimModel
            ::select([
                'department_name as 采购主体',
                'product_title as 采购产品',
                'supplier_name as 供应商名称',
                'purchases_time as 采购时间',
                'quantity as 采购数量',
                'purchases_price as 采购金额',
                'invoice_start_time as 来票时间',
                'total_money as 来票金额',
                'payment_time as 付款时间',
                'payment_price as 	付款金额',

            ]);
        return $purchasesObj;
    }

    /**
     * 按时间导出采购单
     */
    public function dateGetPurchases(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start_date = date("Y-m-d H:i:s",strtotime($start_date));
        $end_date = date("Y-m-d H:i:s",strtotime($end_date));

        //查询付款单数据集合
        $query = $this->purchasesSelect();

        $data = $query->whereBetween('payment_time', [$start_date, $end_date])->get();

        //导出Excel表单
        $this->createExcel($data,'采购明细');
    }


}
