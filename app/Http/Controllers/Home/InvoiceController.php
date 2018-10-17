<?php

namespace App\Http\Controllers\Home;

use App\Models\ChinaCityModel;
use App\Models\HistoryInvoiceModel;
use App\Models\InvoiceModel;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageModel;
use App\Models\StoreModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * 发票管理中的发票记录
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->tab_menu = 'all';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        $wherein  =  $order_number;
        if($receiving_id ){
            $where['history_invoice.receiving_id'] = $receiving_id;
        } else{
            $where = '';
        }


        $this->per_page = $request->input('per_page', $this->per_page);

        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $status= 'all'; 
        if($where){
            $order_list = $this->invoiceWmd($where,$wherein);
        } else {
            $order_list = $this->invoiceMd($wherein);
        }


        return view('home/invoice.index', [
            'order_list' => $order_list,
            'tab_menu' => $this->tab_menu,
            'status' => $status,
            'per_page' => $this->per_page,
            'order_number' => '',
            'sSearch' => false,
            'products' => $products,
            'from_type' => 0,

        ]);
    }

    /**
     * @param $wherein
     * @return mixed 无where条件sql
     */
    public function invoiceMd($wherein)
    {
        $order_list = OrderModel::whereRaw(DB::raw("((`status` IN (8,10,20) and  `payment_type` = 6) OR (`status` IN (5, 6, 7, 10, 20) and `payment_type` IN (1, 4)))"))
            ->select('order.*','history_invoice.*','order.id as id','history_invoice.id as invoice_id')
            ->leftJoin('history_invoice', 'order.id', '=', 'history_invoice.order_id')
            ->where('order.number','like','%'.$wherein.'%')
            ->orderBy('order.id','desc')
            ->paginate($this->per_page);
        return $order_list;
    }

    /**
     * @param $where
     * @param $wherein
     * @return mixed 有where条件sql
     */
    public function invoiceWmd($where,$wherein)
    {
        $order_list = OrderModel::whereRaw(DB::raw("((`status` IN (8,10,20) and  `payment_type` = 6) OR (`status` IN (5, 6, 7, 10, 20) and `payment_type` IN (1, 4)))"))
            ->select('order.*','history_invoice.*','order.id as id','history_invoice.id as invoice_id')
            ->leftJoin('history_invoice', 'order.id', '=', 'history_invoice.order_id')
            ->where('order.number','like','%'.$wherein.'%')
            ->Where($where)
            ->orderBy('order.id','desc')
            ->paginate($this->per_page);
        return $order_list;
    }

    /**
     * 发票管理中的审核中
     *
     * @return \Illuminate\Http\Response
     */
    public function nonOrderList(Request $request)
    {
        $tab_menu = 'waitpay';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        $wherein  =  $order_number;
        if($receiving_id){
            $where['history_invoice.receiving_id'] = $receiving_id;
            $where['history_invoice.receiving_type'] = 2;
            $where['history_invoice.difference'] = 0;
        }else{
            $where['history_invoice.receiving_type'] = 2;
            $where['history_invoice.difference'] = 0;
        }


        $this->per_page = $request->input('per_page', $this->per_page);


        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();
        $status= 'waitpay';
        $order_list = $this->invoiceWmd($where,$wherein);



        return view('home/invoice.nonOrderList', [
            'order_list' => $order_list,
            'tab_menu' => $tab_menu,
            'status' => $status,
            'per_page' => $this->per_page,
            'order_number' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,
            'from_type' => 0,

        ]);

    }
    /**
     * 发票管理中的已开票
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyOrderList(Request $request)
    {
        $tab_menu = 'waitcheck';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        $wherein  =  $order_number;
        if($receiving_id ){
            $where['history_invoice.receiving_id'] = $receiving_id;
            $where['history_invoice.receiving_type'] = 3;
            $where['history_invoice.difference'] = 0;
        }else{
            $where['history_invoice.receiving_type'] = 3;
            $where['history_invoice.difference'] = 0;
        }

        $this->per_page = $request->input('per_page', $this->per_page);


        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $status= 'waitpay';
        $order_list = $this->invoiceWmd($where,$wherein);


        return view('home/invoice.verifyOrderList', [
            'order_list' => $order_list,
            'tab_menu' => $tab_menu,
            'status' => $status,
            'per_page' => $this->per_page,
            'order_number' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,

            'from_type' => 0,


        ]);

    }

    /**
     * 发票管理中的拒绝
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOrderList(Request $request)
    {
        $tab_menu = 'waitsend';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        $wherein  =  $order_number;
        if($receiving_id ){
            $where['history_invoice.receiving_id'] = $receiving_id;
            $where['history_invoice.receiving_type'] = 4;
            $where['history_invoice.difference'] = -1;
        }else{
            $where['history_invoice.receiving_type'] = 4;
            $where['history_invoice.difference'] = -1;
        }

        $this->per_page = $request->input('per_page', $this->per_page);


        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $status= 'waitpay';
        $order_list = $this->invoiceWmd($where,$wherein);


        return view('home/invoice.sendOrderList', [
            'order_list' => $order_list,
            'tab_menu' => $tab_menu,
            'status' => $status,
            'per_page' => $this->per_page,
            'order_number' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,
            'from_type' => 0,


        ]);

    }

    /**
     * 发票管理中的已过期
     *
     * @return \Illuminate\Http\Response
     */
    public function completeOrderList(Request $request)
    {
        $tab_menu = 'sended';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        $wherein  =  $order_number;
        if($receiving_id ){
            $where['history_invoice.receiving_id'] = $receiving_id;
            $where['history_invoice.receiving_type'] = 5;
            $where['history_invoice.difference'] = 0;
        }else{
            $where['history_invoice.receiving_type'] = 5;
            $where['history_invoice.difference'] = 0;
        }

        $this->per_page = $request->input('per_page', $this->per_page);


        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $status= 'waitpay';
        $order_list = $this->invoiceWmd($where,$wherein);



        return view('home/invoice.completeOrderList', [
            'order_list' => $order_list,
            'tab_menu' => $tab_menu,
            'status' => $status,
            'per_page' => $this->per_page,
            'order_number' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,

        ]);

    }

    /**
     * 发票管理中的审核中的审核拒绝
     *
     * @return \Illuminate\Http\Response
     */
    public function rejected(Request $request)
    {
        $order_id = $request->input('id');
        $invoice_id = $request->input('invoice_id');
        $reason = $request->input('reason');
        $user_id = Auth::user()->id;
        $history = HistoryInvoiceModel::find($invoice_id);
        if(!$history){
            return '500';
        }
        $history['reviewer'] = $user_id;
        $history['audit'] = date('Y-m-d H:i:s',time());
        $history['difference'] = -1;
        $history['receiving_type'] = 4;
        $history['reason'] = $reason;
        if (!$history->save()){
            return '500';
        }

        return 200;

    }
    /**
     * 发票管理中的审核中的审核通过
     *
     * @return \Illuminate\Http\Response
     */
    public function through(Request $request)
    {
        $id = $request->input('id');
        $invoice_id = $request->input('invoice_id');
        $where['order_id'] = $id;
        $where['id'] = $invoice_id;
        $res =  HistoryInvoiceModel::where($where)->first();
        if(!$res){
            return '500';
        }
        $res->difference = 0;
        $res->receiving_type = 3;
        $res->audit = date('Y-m-d H:i:s',time());

        $res->reviewer = Auth::user()->id;

        if($res->save()){
            return 200;
        } else{
            return 500;
        }





    }
    /**
     * 订单管理中的发票记录
     *
     * @return \Illuminate\Http\Response
     */
    public function lists(Request $request)
    {
        $this->tab_menu = 'all';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        $wherein =  $order_number;
        if($receiving_id ){
            $where['i.receiving_id'] = $receiving_id;
        } else{
            $where = '';
        }

        $this->per_page = $request->input('per_page', $this->per_page);

        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $status= 'all';
        if($where){
            $order_list = $this->invoiceWmd($where,$wherein);

        } else {
            $order_list = $this->invoiceMd($wherein);
        }


        return view('home/invoice.invoice', [
            'order_list' => $order_list,
            'tab_menu' => $this->tab_menu,
            'status' => $status,
            'per_page' => $this->per_page,
            'order_number' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,

        ]);
    }

    /**
     * 获取订单及订单明细的详细信息
     * @param Request $request
     * @return string
     */
    public function ajaxEdit(Request $request)
    {
        $order_id = (int)$request->input('id');
        $invoice_id = (int)$request->input('invoice_id');

        if(empty('id') && empty($invoice_id)){
            return ajax_json(0,'error');
        }
        $order = OrderModel::find($order_id); //订单
        $order->logistic_name = $order->logistics ? $order->logistics->name : '';

        $province = ChinaCityModel::where('oid', $order->buyer_province)->select('name')->first();
        $city = ChinaCityModel::where('oid', $order->buyer_city)->select('name')->first();
        $county = ChinaCityModel::where('oid', $order->buyer_county)->select('name')->first();
        $town = ChinaCityModel::where('oid', $order->buyer_township)->select('name')->first();
        if ($province) {
            $order->province = $province->name;
        }
        if ($city) {
            $order->city = $city->name;
        }
        if ($county) {
            $order->county = $county->name;
        }
        if ($town) {
            $order->town = $town->name;
        }
        if ($order->payment_time == '0000-00-00 00:00:00'){
            $order->payment_time = '';
        }
        if ($order->status == 0){
            $order->payment_time = '';
        }
        $where['order_id'] = $order_id;
        $where['id'] = $invoice_id;
        $history =  HistoryInvoiceModel::where($where)->first();
        $between = '';
    if ($history){
        if($history['receiving_type'] != 5){
            $name  = UserModel::where('id',$history['reviewer'])->select('realname')->first();
            $history['username'] = $name['realname'];
            switch($history->receiving_id){
                case $history->receiving_id = 1;
                    $history->receiving_id = '增值税普通发票';
                    $history->prove_id = '';
                    $prove = 0;
                    break;
                case $history->receiving_id = 2;
                    $history->receiving_id = '增值税专用发票';
                    $history->prove_id = $history->getFirstImgInvoice();
                    $prove = 1;
                    break;
                case $history->receiving_id = 0;
                    $history->receiving_id = '未开票';
                    $history->prove_id = '';
                    $prove = 0;
                    break;
                default :
                    $history->receiving_id = '';
                    $history->prove_id = '';
                    $prove = 0;
                    break;
            }
            if($history->receiving_type == 1){
                $history->receiving_type = '未开票';
            } elseif($history->receiving_type == 2){
                $history->receiving_type = '审核中';
                $between = '999';
            }elseif($history->receiving_type == 3){
                $history->receiving_type = '已开票';
            }elseif($history->receiving_type == 4){
                $history->receiving_type = '拒绝';
            }else{
                $history->receiving_type = '';
            }
            $history->invoice_id = $order->id;
            $order->invoices_id = $history['id'];
        }elseif($history['receiving_type'] == 5){
            $history = '';
            $history['company_name'] = '';
            $history['receiving_id'] = '';
            $prove = 0;
            $history['invoice_id'] = $order->id;
        }
    }else{
        $history['company_name'] = '';
        $history['receiving_id'] = '';
        $prove = 0;
        $history['invoice_id'] = $order->id;
    }



        $order->company_name = isset($history['company_name']) ? $history['company_name'] : '';
        $order->receiving_name = isset($history['receiving_name']) ? $history['receiving_name'] : '';
        $order->receiving_phone = isset($history['receiving_phone']) ? $history['receiving_phone'] : '';
        $order->logistic_name = $order->logistics ? $order->logistics->name : '';

        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();

        $product_sku_model = new ProductsSkuModel();
        $order_sku = $product_sku_model->detailedSuks($order_sku); //订单明细

        $express_content_value = [];
        foreach ($order->express_content_value as $v){
            $express_content_value[] = ['key' => $v];
        }

        // 对应出库单
        if ($out_warehouse = OutWarehousesModel::where(['type' => 2, 'target_id' => $order_id])->first()){
            $out_warehouse_number = $out_warehouse->number;
        }else{
            $out_warehouse_number = null;
        }

        return ajax_json(1, 'ok', [
            'order' => $order,
            'prove' => $prove,
            'between'=>$between,
            'history'=>$history,
            'order_sku' => $order_sku,
//            'name' => '',
            'order_status' => '',
            'order_number' => '',
            'product_name' => '',
            'sSearch' => false,
            'express_state_value' => $order->express_state_value,
            'express_content_value' => $express_content_value,
            'out_warehouse_number' => $out_warehouse_number,

        ]);
    }

    /**
     * 获取未通过的发票审核记录
     * @param Request $request
     * @return string
     */
    public function  history(Request $request)
    {
        $id = $request->input('id');
        $where['order_id'] = $id;
        $where['difference'] = -1;

        $history =  HistoryInvoiceModel::where($where)->get();
        foreach ($history as $k=>$v){
            if($v['receiving_id'] == 2){
                $history[$k]['prove_url'] = $v->getFirstImgInvoice();
            }
        }
        return view('home/invoice.history', [
            'history' => $history,
        ]);
    }




}
