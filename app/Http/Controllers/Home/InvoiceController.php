<?php

namespace App\Http\Controllers\Home;

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
use App\Models\SupplierModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        $this->tab_menu = 'all';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        if($order_number && $receiving_id ){
            $where['order.number']  =  $order_number;
            $where['i.receiving_id'] = $receiving_id;
        } elseif($order_number){
            $where['order.number']  =  $order_number;
        } elseif($receiving_id){
            $where['i.receiving_id'] = $receiving_id;
        }else{
            $where = '';
        }


        $this->per_page = $request->input('per_page', $this->per_page);


        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $supplier_model = new SupplierModel();
        $supplier_list = $supplier_model->lists();
        $distributors = UserModel::where('supplier_distributor_type' , 1)->get();

        //当前用户所在部门创建的订单 查询条件
        $department = Auth::user()->department;
        if($department){
            $id_arr = UserModel
                ::where('department',$department)
                ->get()
                ->pluck('id')
                ->toArray();
            $query = OrderModel::whereIn('user_id_sales', $id_arr);
        }else{
            $query = OrderModel::query();
        }
        $status= 'all';
        $number = '';
        if($where){
            $order_list = $query
                ->leftjoin('history_invoice as i', 'order.id', '=', 'i.order_id')
                ->select('order.*','i.*','order.id as id','i.id as invoice_id')
                ->whereIn('order.status', [8, 10, 20])
                ->Where($where)
                ->orderBy('order.id','desc')
                ->paginate($this->per_page);
        } else {
            $order_list = $query
                ->leftjoin('history_invoice as i', 'order.id', '=', 'i.order_id')
                ->select('order.*','i.*','order.id as id','i.id as invoice_id')
                ->whereIn('order.status', [8, 10, 20])
                ->orderBy('order.id','desc')
                ->paginate($this->per_page);
        }

//dd($order_list);
        $logistics_list = $logistic_list = LogisticsModel
            ::OfStatus(1)
            ->select(['id','name'])
            ->get();
//        dd($order_list[36]);

        return view('home/invoice.index', [
            'order_list' => $order_list,
            'tab_menu' => $this->tab_menu,
            'status' => $status,
            'logistics_list' => $logistics_list,
            'name' => $number,
            'per_page' => $this->per_page,
            'order_status' => '',
            'order_number' => '',
            'product_name' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,
            'buyer_name' => '',
            'buyer_phone' => '',
            'supplier_id' => '',
            'from_type' => 0,
            'supplier_list' => $supplier_list,
            'distributors' => $distributors,

        ]);
    }

    public function nonOrderList(Request $request)
    {


            $tab_menu = 'waitpay';
            $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
            $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
            $wherein  =  $order_number;
            if($receiving_id){
                $where['i.receiving_id'] = $receiving_id;
                $where['i.receiving_type'] = 2;
                $where['i.difference'] = 0;
            }else{
                $where['i.receiving_type'] = 2;
                $where['i.difference'] = 0;
            }


            $this->per_page = $request->input('per_page', $this->per_page);


            $store_list = StoreModel::select('id','name')->get();
            $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

            $supplier_model = new SupplierModel();
            $supplier_list = $supplier_model->lists();
            $distributors = UserModel::where('supplier_distributor_type' , 1)->get();

            //当前用户所在部门创建的订单 查询条件
            $department = Auth::user()->department;
            if($department){
                $id_arr = UserModel
                    ::where('department',$department)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                $query = OrderModel::whereIn('user_id_sales', $id_arr);
            }else{
                $query = OrderModel::query();
            }
            $status= 'waitpay';
            $number = '';

                $order_list = $query
                    ->leftjoin('history_invoice as i', 'order.id', '=', 'i.order_id')
                    ->select('order.*','i.*','order.id as id','i.id as invoice_id')
                    ->whereIn('order.status', [8, 10, 20])
                    ->where('order.number','like','%'.$wherein.'%')
                    ->where($where)
                    ->orderBy('order.id','desc')
                    ->paginate($this->per_page);

            $logistics_list = $logistic_list = LogisticsModel
                ::OfStatus(1)
                ->select(['id','name'])
                ->get();
//        dd($order_list);

            return view('home/invoice.nonOrderList', [
                'order_list' => $order_list,
                'tab_menu' => $tab_menu,
                'status' => $status,
                'logistics_list' => $logistics_list,
                'name' => $number,
                'per_page' => $this->per_page,
                'order_status' => '',
                'order_number' => '',
                'product_name' => '',
                'sSearch' => false,
                'store_list' => $store_list,
                'products' => $products,
                'buyer_name' => '',
                'buyer_phone' => '',
                'supplier_id' => '',
                'from_type' => 0,
                'supplier_list' => $supplier_list,
                'distributors' => $distributors,

            ]);

    }

    public function verifyOrderList(Request $request)
    {
        $tab_menu = 'waitcheck';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        $wherein  =  $order_number;
        if($receiving_id ){
            $where['i.receiving_id'] = $receiving_id;
            $where['i.receiving_type'] = 3;
            $where['difference'] = 0;
        }else{
            $where['i.receiving_type'] = 3;
            $where['i.difference'] = 0;
        }

//dd($where);
        $this->per_page = $request->input('per_page', $this->per_page);


        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $supplier_model = new SupplierModel();
        $supplier_list = $supplier_model->lists();
        $distributors = UserModel::where('supplier_distributor_type' , 1)->get();

        //当前用户所在部门创建的订单 查询条件
        $department = Auth::user()->department;
        if($department){
            $id_arr = UserModel
                ::where('department',$department)
                ->get()
                ->pluck('id')
                ->toArray();
            $query = OrderModel::whereIn('user_id_sales', $id_arr);
        }else{
            $query = OrderModel::query();
        }
        $status= 'waitpay';
        $number = '';

        $order_list = $query
            ->leftjoin('history_invoice as i', 'order.id', '=', 'i.order_id')
            ->select('order.*','i.*','order.id as id','i.id as invoice_id')
            ->whereIn('order.status', [8, 10, 20])
            ->where('order.number','like','%'.$wherein.'%')
            ->where($where)
            ->orderBy('order.id','desc')
            ->paginate($this->per_page);

        $logistics_list = $logistic_list = LogisticsModel
            ::OfStatus(1)
            ->select(['id','name'])
            ->get();
//        dd($order_list);

        return view('home/invoice.verifyOrderList', [
            'order_list' => $order_list,
            'tab_menu' => $tab_menu,
            'status' => $status,
            'logistics_list' => $logistics_list,
            'name' => $number,
            'per_page' => $this->per_page,
            'order_status' => '',
            'order_number' => '',
            'product_name' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,
            'buyer_name' => '',
            'buyer_phone' => '',
            'supplier_id' => '',
            'from_type' => 0,
            'supplier_list' => $supplier_list,
            'distributors' => $distributors,

        ]);

    }

    public function rejected(Request $request)
    {
        $order_id = $request->input('id');
        $invoice_id = $request->input('invoice_id');


    }

    public function through(Request $request)
    {
        $id = $request->input('id');
        $invoice_id = $request->input('invoice_id');
        $where['order_id'] = $id;
        $where['id'] = $invoice_id;
        $res =  HistoryInvoiceModel::where($where)->first();
        if(!$res){
            return '无数据';
        }
        $res->difference = 0;
        $res->receiving_type = 3;
        $res->audit = date('Y-m-d H:i:s',time());
//        dd($res);
        $res->reviewer = Auth::user()->id;

        if($res->save()){
            return redirect('/invoice/nonOrderList');
        } else{
            return redirect('home/invoice');
        }





    }
    public function lists(Request $request)
    {
        $this->tab_menu = 'all';
        $order_number =  $request->input('order_number')  ? $request->input('order_number') : '';
        $receiving_id =  $request->input('receiving_id')  ? $request->input('receiving_id') : '';
        if($order_number && $receiving_id ){
            $where['order.number']  =  $order_number;
            $where['i.receiving_id'] = $receiving_id;
        } elseif($order_number){
            $where['order.number']  =  $order_number;
        } elseif($receiving_id){
            $where['i.receiving_id'] = $receiving_id;
        }else{
            $where = '';
        }


        $this->per_page = $request->input('per_page', $this->per_page);


        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $supplier_model = new SupplierModel();
        $supplier_list = $supplier_model->lists();
        $distributors = UserModel::where('supplier_distributor_type' , 1)->get();

        //当前用户所在部门创建的订单 查询条件
        $department = Auth::user()->department;
        if($department){
            $id_arr = UserModel
                ::where('department',$department)
                ->get()
                ->pluck('id')
                ->toArray();
            $query = OrderModel::whereIn('user_id_sales', $id_arr);
        }else{
            $query = OrderModel::query();
        }
        $status= 'all';
        $number = '';
        if($where){
            $order_list = $query
                ->leftjoin('history_invoice as i', 'order.id', '=', 'i.order_id')
                ->select('order.*','i.*','order.id as id','i.id as invoice_id')
                ->whereIn('order.status', [8, 10, 20])
                ->Where($where)
                ->orderBy('order.id','desc')
                ->paginate($this->per_page);
        } else {
            $order_list = $query
                ->leftjoin('history_invoice as i', 'order.id', '=', 'i.order_id')
                ->select('order.*','i.*','order.id as id','i.id as invoice_id')
                ->whereIn('order.status', [8, 10, 20])
                ->orderBy('order.id','desc')
                ->paginate($this->per_page);
        }

//dd($order_list);
        $logistics_list = $logistic_list = LogisticsModel
            ::OfStatus(1)
            ->select(['id','name'])
            ->get();
//        dd($order_list);

        return view('home/invoice.invoice', [
            'order_list' => $order_list,
            'tab_menu' => $this->tab_menu,
            'status' => $status,
            'logistics_list' => $logistics_list,
            'name' => $number,
            'per_page' => $this->per_page,
            'order_status' => '',
            'order_number' => '',
            'product_name' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,
            'buyer_name' => '',
            'buyer_phone' => '',
            'supplier_id' => '',
            'from_type' => 0,
            'supplier_list' => $supplier_list,
            'distributors' => $distributors,

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
        $where['order_id'] = $order_id;
//        $where['difference'] = 0;
        $where['id'] = $invoice_id;
        $history =  HistoryInvoiceModel::where($where)->first();
        if($history){
           $name  = UserModel::where('id',$history['reviewer'])->select('realname')->first();
            $history['username'] = $name['realname'];

            if($history->receiving_id == 1){
                $history->receiving_id = '增值税普通发票';
                $history->prove_id = '';
                $prove = 0;
            } elseif($history->receiving_id == 2){
                $history->receiving_id = '增值税专用发票';
                $history->prove_id = $history->getFirstImgInvoice();
                $prove = 1;
            } elseif($history->receiving_id == 0){
                $history->receiving_id = '未开票';
                $history->prove_id = '';
                $prove = 0;
            } else {
                $history->receiving_id = '';
                $history->prove_id = '';
                $prove = 0;
            }
            if($history->receiving_type == 1){
                $history->receiving_type = '未开票';
            } elseif($history->receiving_type == 2){
                $history->receiving_type = '审核中';
            }elseif($history->receiving_type == 3){
                $history->receiving_type = '已开票';
            }elseif($history->receiving_type == 4){
                $history->receiving_type = '拒绝';
            }else{
                $history->receiving_type = '';
            }
            $history->invoice_id = $order->id;
            $order->invoices_id = $history['id'];
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
        /*$order->storage_name = $order->storage->name;*/

        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();

        $product_sku_model = new ProductsSkuModel();
        $order_sku = $product_sku_model->detailedSuks($order_sku); //订单明细

        // 仓库信息
        $storage_list = StorageModel::OfStatus(1)->select(['id','name'])->get();
        if (!empty($storage_list)) {
            $max = count($storage_list);
            for ($i=0; $i<$max; $i++) {
                if ($storage_list[$i]['id'] == $order->storage_id) {
                    $storage_list[$i]['selected'] = 'selected';
                } else {
                    $storage_list[$i]['selected'] = '';
                }
            }
        }
        // 物流信息
        $logistic_list = LogisticsModel::OfStatus(1)->select(['id','name'])->get();
        if (!empty($logistic_list)) {
            $max = count($logistic_list);
            for ($k=0; $k<$max; $k++) {
                if ($logistic_list[$k]['id'] == $order->express_id) {
                    $logistic_list[$k]['selected'] = 'selected';
                } else {
                    $logistic_list[$k]['selected'] = '';
                }
            }
        }

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
            'history'=>$history,
            'order_sku' => $order_sku,
            'storage_list' => $storage_list,
            'logistic_list' => $logistic_list,
            'name' => '',
            'order_status' => '',
            'order_number' => '',
            'product_name' => '',
            'sSearch' => false,
            'express_state_value' => $order->express_state_value,
            'express_content_value' => $express_content_value,
            'out_warehouse_number' => $out_warehouse_number,

        ]);
    }


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




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
