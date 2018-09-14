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

        $per_page = $request->input('per_page',50);
        $category = new InvoiceModel();
        $where['receiving_type'] = 2;
        $lists = $category->where($where)->paginate($per_page);

        return view("home/invoice.index", [
            'lists' => $lists,

        ]);
    }

    public function lists(Request $request)
    {
        $this->tab_menu = 'all';
        $this->per_page = $request->input('per_page', $this->per_page);
//        $status = 'all';
//        $store_list = StoreModel::select('id','name')->get();
//        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();
//
//        $supplier_model = new SupplierModel();
//        $supplier_list = $supplier_model->lists();
//        $distributors = UserModel::where('supplier_distributor_type' , 1)->get();
//
//        //当前用户所在部门创建的订单 查询条件
//        $department = Auth::user()->department;
//        if($department){
//            $id_arr = UserModel
//                ::where('department',$department)
//                ->get()
//                ->pluck('id')
//                ->toArray();
//            $query = OrderModel::whereIn('user_id_sales', $id_arr);
//        }else{
//            $query = OrderModel::query();
//        }
//
//        $number = '';
//        if ($status === 'all') {
//            $order_list = $query
//                ->orderBy('id','desc')
//                ->paginate($this->per_page);
//        } else {
//            $order_list = $query
//                ->where(['status' => $status, 'suspend' => 0])
//                ->orderBy('id','desc')
//                ->paginate($this->per_page);
//        }
//
//        $logistics_list = $logistic_list = LogisticsModel
//            ::OfStatus(1)
//            ->select(['id','name'])
//            ->get();
//
//        return view('home/order.invoice', [
//            'order_list' => $order_list,
//            'tab_menu' => $this->tab_menu,
//            'status' => $status,
//            'logistics_list' => $logistics_list,
//            'name' => $number,
//            'per_page' => $this->per_page,
//            'order_status' => '',
//            'order_number' => '',
//            'product_name' => '',
//            'sSearch' => false,
//            'store_list' => $store_list,
//            'products' => $products,
//            'buyer_name' => '',
//            'buyer_phone' => '',
//            'supplier_id' => '',
//            'from_type' => 0,
//            'supplier_list' => $supplier_list,
//            'distributors' => $distributors,
//
//        ]);
//    {
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
        $order_list = $query
            ->leftjoin('history_invoice as i', 'order.id', '=', 'i.order_id')
            ->select('order.*','i.*','order.id as id','i.id as invoice_id')
            ->orderBy('order.id','desc')
            ->paginate($this->per_page);

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

        if(empty('id')){
            return ajax_json(0,'error');
        }
        $order = OrderModel::find($order_id); //订单

        $order->logistic_name = $order->logistics ? $order->logistics->name : '';
        /*$order->storage_name = $order->storage->name;*/

        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();

        $product_sku_model = new ProductsSkuModel();
        $order_sku = $product_sku_model->detailedSku($order_sku); //订单明细

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
