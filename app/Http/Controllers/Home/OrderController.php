<?php

namespace App\Http\Controllers\Home;

use App\Helper\JdApi;
use App\Helper\KdnOrderTracesSub;
use App\Helper\ShopApi;
use App\Helper\KdniaoApi;
use App\Helper\TaobaoApi;
use App\Http\Requests\UpdateOrderRequest;

use App\Jobs\PushExpressInfo;

use App\Models\ChinaCityModel;
use App\Models\CountersModel;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\ReceiveOrderModel;
use App\Models\RefundMoneyOrderModel;
use App\Models\StorageModel;
use App\Models\StorageSkuCountModel;
use App\Models\StoreModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Common\JdSdkController;

class OrderController extends Controller
{
    /**
     * 初始化
     */
    public function __construct()
    {
        // 设置菜单状态
        View()->share('tab_menu', 'active');
    }   
    
    /**
     * 订单查询.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->tab_menu = 'all';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list();
    }
    
    /**
     * 筛选订单列表
     */
    protected function display_tab_list($status='all')
    {
        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();

        $supplier_model = new SupplierModel();
        $supplier_list = $supplier_model->lists();
        $distributors = UserModel::where('type' , 1)->get();

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

        $number = '';
        if ($status === 'all') {
            $order_list = $query
                ->orderBy('id','desc')
                ->paginate($this->per_page);
        } else {
            $order_list = $query
                ->where(['status' => $status, 'suspend' => 0])
                ->orderBy('id','desc')
                ->paginate($this->per_page);
        }

        $logistics_list = $logistic_list = LogisticsModel
            ::OfStatus(1)
            ->select(['id','name'])
            ->get();

        return view('home/order.order', [
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
            'from_type' => 0,
            'supplier_list' => $supplier_list,
            'distributors' => $distributors,

        ]);
    }

    /**
     * 未付款订单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nonOrderList(Request $request)
    {
        $this->tab_menu = 'waitpay';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(1);
    }

    /**
     * 待审核订单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verifyOrderList(Request $request)
    {
        $this->tab_menu = 'waitcheck';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(5);
    }

    /**
     * 反审订单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reversedOrderList(Request $request)
    {
        $this->tab_menu = 'waitcheck';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(8);
    }

    /**
     * 待打印发货列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendOrderList(Request $request)
    {
        $this->tab_menu = 'waitsend';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(8);
    }

    /**
     * 已发货列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function completeOrderList(Request $request)
    {        
        $this->tab_menu = 'sended';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(10);
    }

    /**
     * 售后中订单列表
     */
    public function servicingOrderList(Request $request)
    {
        $this->per_page = $request->input('per_page',$this->per_page);
        $order_list = OrderModel::where(['suspend' => 1])->orderBy('id','desc')->paginate($this->per_page);
        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::where('product_type' , 1)->get();
        $supplier_model = new SupplierModel();
        $supplier_list = $supplier_model->lists();
        $distributors = UserModel::where('type' , 1)->get();

        $logistics_list = LogisticsModel::OfStatus(1)->select(['id','name'])->get();
        return view('home/order.order', [
            'order_list' => $order_list,
            'tab_menu' => 'servicing',
            'status' => '',
            'logistics_list' => $logistics_list,
            'name' => '',
            'per_page' => $this->per_page,
            'order_status' => '',
            'order_number' => '',
            'product_name' => '',
            'sSearch' => false,
            'store_list' => $store_list,
            'products' => $products,
            'buyer_name' => '',
            'buyer_phone' => '',
            'from_type' => 0,
            'supplier_list' => $supplier_list,
            'distributors' => $distributors,

        ]);
    }

    /**
     * 完成订单列表
     */
    public function finishedOrderList(Request $request)
    {
        $this->tab_menu = 'finished';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(20);
    }

    /**
     * 取消订单列表
     */
    public function closedOrderList(Request $request)
    {
        $this->tab_menu = 'closed';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storage_list = StorageModel::ofStatus(1)->select('id','name')->get();

        $store_list = StoreModel::select('id','name')->get();

        $logistic_list = LogisticsModel::ofstatus(1)->select('id','name')->get();

        $china_city = ChinaCityModel::where('layer',1)->get();

        $user_list = UserModel::ofStatus(1)->select('id','realname')->get();

        return view('home/order.createOrder', [
            'storage_list' => $storage_list, 
            'store_list' => $store_list,
            'logistic_list' => $logistic_list,
            'china_city' => $china_city,
            'user_list' => $user_list,
            'name' => '',
            'order_status' => '',
            'order_number' => '',
            'product_name' => '',
            'sSearch' => false,


        ]);
    }
    
    public function ajaxOrder(Request $request){
        return ajax_json(1,'ok');
    }

    /**
     * 获取指定仓库、部门sku列表
     * @param Request $request
     * @return string
     */
    public function ajaxSkuList(Request $request){
        $storage_id = (int)$request->input('id');
        $user_id_sales = (int)$request->input('user_id_sales');
        if(empty($storage_id) || empty($user_id_sales)){
            return ajax_json(0,'参数错误');
        }
        $user = UserModel::find($user_id_sales);
        $department = $user->department;
        $storage_sku_model = new StorageSkuCountModel();
        $sku_list = $storage_sku_model->skuList($storage_id,$department);
        return ajax_json(1,'ok',$sku_list);
    }

    /**
     * 创建一个新的订单.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try{
            $all = $request->all();
            $user_id_sales = $request->input('user_id_sales',0);
            $user = UserModel::find($user_id_sales);
            $storage_sku = new StorageSkuCountModel();
            if(!$storage_sku->isCount($all['sku_storage_id'][0], $user->department,$all['sku_id'], $all['quantity'])){
                return "仓库/部门库存不足";
            }

            $total_money = 0.00;
            $discount_money = 0.00;
            $count = 0;
            for($i=0;$i<count($all['quantity']);$i++){
                $total_money += $all['quantity'][$i] * $all['price'][$i];
                $discount_money += $all['discount'][$i] * $all['quantity'][$i];
                $count += $all['quantity'][$i];
            }


            $all = $request->except(['sku_id','sku_storage_id','price','quantity','discount']);
            $all['user_id'] = Auth::user()->id;
            $all['status'] = 5;
            $all['total_money'] = $total_money;
            $all['discount_money'] = $discount_money;
            $all['pay_money'] = $total_money + $all['freight'] - $discount_money;
            $all['count'] = $count;
            
            $number = CountersModel::get_number('DD');
            $all['number'] = $number;

            $all['user_id_sales'] = $request->input('user_id_sales',0);
            $all['order_user_id'] = $request->input('order_user_id',0);
            $all['buyer_province'] = $request->input('province_id','');
            $all['buyer_city'] = $request->input('city_id','');
            $all['buyer_county'] = $request->input('county_id','');
            //判断是否存在四级城市
                $all['buyer_township'] = $request->input('township_id','');

            //添加创建订单时间
            $all['order_start_time'] = date("Y-m-d H:i:s");

            DB::beginTransaction();
            if(!$order_model = OrderModel::create($all)){
                DB::rollBack();
                return '参数错误';
            }

            $all = $request->all();
            $order_id = $order_model->id;
            for($i=0;$i<count($all['sku_id']);$i++){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_id = $all['sku_id'][$i];
                $product_sku_id = $all['sku_id'][$i];
                if(!$product_sku_model = ProductsSkuModel::find($product_sku_id)){
                    DB::rollBack();
                    return '参数错误';
                }
                $order_sku_model->sku_number = $product_sku_model->number;
                $order_sku_model->sku_name = $product_sku_model->product->title . '--' . $product_sku_model->mode;
                $order_sku_model->product_id = $product_sku_model->product->id;
                $order_sku_model->quantity = $all['quantity'][$i];
                $order_sku_model->price = $all['price'][$i];
                $order_sku_model->discount = $all['discount'][$i];
                if(!$order_sku_model->save()){
                    DB::rollBack();
                    return '参数错误';
                }

                //订单付款占货
                if(!$product_sku_model->increasePayCount($order_sku_model->sku_id,$order_sku_model->quantity)){
                    DB::rollBack();
                    return '付款占货关联操作失败';
                }
            }

            // 创建订单收款单
            $model = new ReceiveOrderModel();
            if (!$model->orderCreateReceiveOrder($order_id)) {
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货创建订单收款单错误');
                return 'ID:'. $order_id .'订单发货创建订单收款单错误';
            }

            DB::commit();
            return redirect('/order/verifyOrderList');
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
            return '内部错误';
        }
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
     * 修改订单信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxUpdate(UpdateOrderRequest $request)
    {
        $order_id = (int)$request->input('order_id');
        $all = $request->all();
        $order_model = OrderModel::find($order_id);

        //判断该订单是否允许修改
        if(!$order_model->change_status){
            return ajax_json(0,'禁止修改！！！');
        }

        if(!$order_model){
            return ajax_json(0,'参数错误');
        }
        DB::beginTransaction();
        if(!$order_model->update($all)){
            DB::rollBack();
            return ajax_json(0,'error');
        }
        
        if(!empty($skus = $request->input('skus'))){
            foreach ($skus as $sku){
                $order_sku = new OrderSkuRelationModel();
                $order_sku->order_id = $order_id;
                $order_sku->sku_id = $sku['sku_id'];
                $order_sku->product_id = $sku['product_id'];
                $order_sku->quantity = 1;
                $order_sku->price = 0;
                $order_sku->discount = $sku['price'];
                $order_sku->status = 1;
                if(!$order_sku->save()){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }
            }

        }
        DB::commit();
        return ajax_json(1,'ok');
    }

    /**
     * 删除自建订单(删除自建订单为关联完全删除（删除对应收款单、恢复订单付款占货、删除出库单）)
     *
     * @param Request $request
     * @return string
     */
    public function ajaxDestroy(Request $request)
    {
        //判断角色是否有权删除
        if(!Auth::user()->hasRole(['admin','director','shopkeeper'])){
            return ajax_json(0,'参数错误');
        }

        $order_id = (int)$request->input('order_id');
        if(empty($order_id)){
            return ajax_json(0,'参数错误');
        }

        try{
            $order_model = OrderModel::find($order_id);
            if(!$order_model){
                return ajax_json(0,'订单不存在');
            }

            if($order_model->type == 3){
                return ajax_json(0,'error');
            }

            DB::beginTransaction();
            //判断订单属于待付款还是付款，进行相应取消占货操作(1.待付款 5.待审核；8.待发货；10.已发货；20.完成)
            switch ($order_model->status){
                case 1:
                    $productsSkuModel = new ProductsSkuModel();
                    if(!$productsSkuModel->orderDecreaseReserveCount($order_id)){
                        DB::rollBack();
                        return ajax_json(0,"内部错误1");
                    }
                    break;
                case 5:
                case 8:
                case 10:
                case 20:
                    $productsSkuModel = new ProductsSkuModel();
                    if(!$productsSkuModel->orderDecreasePayCount($order_id)){
                        DB::rollBack();
                        return ajax_json(0,"内部错误2");
                    }
                    break;
                default:
                    DB::rollBack();
                    return "内部错误3";
            }

            //完全删除对应收款单
            $receiveOrder = $order_model->receiveOrder;
            if($receiveOrder){
                $receiveOrder->forceDelete();
            }

            //完全删除对应出库单及明细
            $out_warehouse = OutWarehousesModel::where(['type' => 2, 'target_id' => $order_model->id])->first();
            if($out_warehouse){
                if(!$out_warehouse->deleteOutWarehouse()){
                    DB::rollBack();
                    return "内部错误5";
                }
            }

            //完全删除订单及明细
            if(!$order_model->deleteOrder()){
                DB::rollBack();
                return "内部错误6";
            }

            DB::commit();
            return ajax_json(1,'ok');
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            return $e->getMessage();
        }
    }

    /**
     * 批量审核订单
     *
     * @param array $order_id_array
     * @return string
     */
    public function ajaxVerifyOrder(Request $request)
    {
        $order_id_array = $request->input('order');

        foreach ($order_id_array as $order_id) {

            $order_model = OrderModel::find($order_id);
            if($order_model->status != 5 || $order_model->suspend == 1){
                return ajax_json(0,'该订单不属待审核状态');
            }

            //判断仓库库存是否满足订单
            $order_sku = $order_model->orderSkuRelation;
            $storage_id = $order_model->storage_id;
            $sku_id_arr = [];
            $sku_count_arr = [];
            foreach ($order_sku as $sku){
                $sku_id_arr[] = $sku->sku_id;
                $sku_count_arr[] = $sku->quantity;
            }

            if(empty($order_model->user_id_sales)){
                DB::rollBack();
                return ajax_json(0,'参数错误，not department');
            }
            $department = UserModel::find($order_model->user_id_sales) ? UserModel::find($order_model->user_id_sales)->department : '';
dd($department);
            $storage_sku = new StorageSkuCountModel();
            if(!$storage_sku->isCount($storage_id, $department, $sku_id_arr, $sku_count_arr)){
                DB::rollBack();
                return ajax_json(0,'发货商品所选仓库/部门库存不足');
            }

            DB::beginTransaction();
            $order_model->verified_user_id = Auth::user()->id;
            $order_model->order_verified_time = date("Y-m-d H:i:s");

            if (!$order_model->save()){
                DB::rollBack();
                return ajax_json(0,'内部错误');
            }

            if (!$order_model->changeStatus($order_id, 8)) {
                DB::rollBack();
                return ajax_json(0,'审核失败');
            }

            if (!$order_model->daifaSplit($order_model)){
                DB::rollBack();
                return ajax_json(0,'代发拆单失败');
            }

            DB::commit();
        }
        
        return ajax_json(1, 'ok');
    }

    /**
     * 批量反审订单
     *
     * @param array $order_id_array
     * @return string
     */
    public function ajaxReversedOrder(Request $request)
    {
        $order_id_array = $request->input('order');
        foreach ($order_id_array as $order_id){
            $order_model = OrderModel::find($order_id);
            if($order_model->status != 8 || $order_model->suspend == 1){
                return ajax_json(0,'该订单不能反审');
            }
            if(!$order_model->changeStatus($order_id, 5)){
                return ajax_json(0,'反审失败');
            }
        }
        
        return ajax_json(1,'ok');
    }

    /**
     * 打印发货订单
     *
     * @param array $order_id_array
     * @return string
     */
    public function ajaxSendOrder1(Request $request)
    {
        try {
            $order_id = (int)$request->input('order_id');
            $order_model = OrderModel::find($order_id);
            
            // 1、验证订单状态，仅待发货订单，才继续
            if ($order_model->status != 8 || $order_model->suspend == 1) {
                return ajax_json(0, 'error', '该订单不是待发货订单');
            }
            
            DB::beginTransaction();

            $order_model->send_user_id = Auth::user()->id;
            $order_model->order_send_time = date("Y-m-d H:i:s");
            
            if (!$order_model->changeStatus($order_id, 10)) {
                DB::rollBack();
                Log::error('Send Order ID:'. $order_id .'订单发货修改状态错误');
                return ajax_json(0, 'error', '订单发货修改状态错误');
            }

            // 创建出库单
            $out_warehouse = new OutWarehousesModel();
            if (!$out_warehouse->orderCreateOutWarehouse($order_id)) {
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货,创建出库单错误');
                return ajax_json(0,'error','订单发货,创建出库单错误');
            }

            //打印信息数据
            $printData = '';

            /**
             * 判断是否手动发货
             */
            $logistics_type = $request->input('logistics_type');
            //手动发货，获取快递公司ID  快递单号
            if($logistics_type == true){
                $logistics_id = $request->input('logistics_id');
                $logistics_no = $request->input('logistics_no');

                if ($LogisticsModel = LogisticsModel::find($logistics_id)){
                    $kdn_logistics_id = $LogisticsModel->kdn_logistics_id;
                }else{
                    DB::rollBack();
                    return ajax_json(0,'error','物流不存在');
                }

            }else{
                // 调取菜鸟Api，获取快递单号，电子面单相关信息
                /*$kdniao = new KdniaoApi();
                $consignor_info = $kdniao->pullLogisticsNO($order_id);*/
                $taobaoApi = new TaobaoApi();
                $waybill = $taobaoApi->getWaybill($order_id);

                if (property_exists($waybill[0],'code')) {
                    DB::rollBack();
                    Log::error('Get cainiao, order id:'. $order_id . $waybill[0]->sub_msg);
                    return ajax_json(0,'error：' . $waybill[0]->code . $waybill[0]->sub_msg);
                }

                $waybill_info = $waybill[0]->modules->waybill_cloud_print_response[0];
                $cp_code = $waybill[1];
                $kdn_logistics_id = $cp_code;
                $logistics_no  = $waybill_info->waybill_code;
                // 面单打印模板
                $printData = $waybill_info->print_data;
                //将快递鸟物流代码转成本地物流ID
                $logisticsModel = LogisticsModel::where('kdn_logistics_id',$kdn_logistics_id)->first();
                if(!$logisticsModel){
                    DB::rollBack();
                    return ajax_json(0,'error','物流不存在');
                }
                $logistics_id = $logisticsModel->id;
            }



            //快递单号保存
            $order_model->express_no = $logistics_no;
            if(!$order_model->save()){
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单运单号保存失败');
                return ajax_json(0,'error','订单运单号保存失败');
            }

            //判断是否是平台同步的订单
            if($order_model->type == 3){
                // 订单发货同步到平台
                $job = (new PushExpressInfo($order_id, $logistics_id, $logistics_no))->onQueue('syncExpress');
                $this->dispatch($job);
            }

            //订阅订单物流
            $KdnOrderTracesSub = new KdnOrderTracesSub();
            $KdnOrderTracesSub->orderTracesSubByJson($kdn_logistics_id, $logistics_no, $order_id);

            DB::commit();
            
            return ajax_json(1,'ok',[
                'printData' => $printData,
                'waybillNO' => $logistics_no,
                ]);
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
        }
    }

    /**
     * 通过sku编号或商品名称 搜索指定仓库的中的sku信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxSkuSearch(Request $request){
        $storage_id = (int)$request->input('storage_id');
        $user_id_sales = (int)$request->input('user_id_sales');
        $where = $request->input('where');

        $user = UserModel::find($user_id_sales);
        $department = $user->department;

        $storage_sku_count = new StorageSkuCountModel();
        $sku_list = $storage_sku_count->search($storage_id, $department, $where);
        if(!$sku_list){
            ajax_json(0,'null');
        }
        $product_sku = new ProductsSkuModel();
        $product_sku = $product_sku->detailedSku($sku_list);
        return ajax_json(1,'ok',$product_sku);
    }

    /**
     * 订单打印发货信息同步到对应平台
     *
     * @param $order_id
     * @return bool
     */
    public function pushOrderSend($order_id, $logistics_id, $waybill)
    {
        if(!$orderModel = OrderModel::find($order_id)){
            return false;
        }
        $platform = $orderModel->store->platform;
        switch ($platform){
            case 1:
                //淘宝平台
                break;
            case 2:
                $api = new JdApi();
                return $api->outStorage($order_id,$logistics_id,$waybill);
                break;
            case 3:
                //自营平台
                $shopApi = new ShopApi();
                return $shopApi->send_goods($order_id,$logistics_id,$waybill);
                break;
        }
    }
    
    

    /**
     * 订单拆单
     *
     * @param Request $request
     * @return string
     */
    public function splitOrder(Request $request)
    {
        $data = $request->input('data');
        $orderModel = new OrderModel();
        $result = $orderModel->splitOrder($data);
        if(!$result[0]){
            return ajax_json(0,$result[1]);
        }

        return ajax_json(1,'ok');
    }

    /*
     * 搜索
     */
    public function search(Request $request,$status='')
    {
        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();
        $this->per_page = $request->input('per_page',$this->per_page);
        $number = $request->input('number');
        $order_list = OrderModel
            ::where('number','like','%'.$number.'%')
            ->paginate($this->per_page);
        $logistics_list = $logistic_list = LogisticsModel::OfStatus(1)->select(['id','name'])->get();
        return view('home/order.order', [
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
            'from_type' => '',
        ]);
    }

    /**
     * 高级搜索
     */
    public function seniorSearch(Request $request)
    {
        $store_list = StoreModel::select('id','name')->get();
        $products = ProductsModel::whereIn('product_type' , [1,2,3])->get();
        $order_status = $request->input('order_status');
        $product_name = $request->input('product_name');
        $order_number = $request->input('order_number');
        $buyer_name = $request->input('buyer_name');
        $buyer_phone = $request->input('buyer_phone');
        $from_type = $request->input('from_type');
        $this->per_page = $request->input('per_page',$this->per_page);
        $orders = OrderModel::query();
        if(!empty($order_number)){
            $orders->where('number' ,'like','%'.$order_number.'%');
        }
        if($order_status !== "no"){
            $orders->where('status' ,$order_status);
        }
        if(!empty($buyer_name)){
            $orders->where('buyer_name' ,'like','%'.$buyer_name.'%');
        }
        if(!empty($buyer_phone)){
            $orders->where('buyer_phone' ,'like','%'.$buyer_phone.'%');
        }
        if($from_type !== 0){
            $orders->where('from_type' , $from_type);
        }
        $order_id = [];
        if(!empty($product_name)){
            $order_sku_relations = OrderSkuRelationModel::where('sku_name' , 'like','%'.$product_name.'%')->get();
            foreach ($order_sku_relations as $order_sku_relation) {
                $order_id[] = $order_sku_relation->order_id;
            }
            $orders->whereIn('id' , $order_id);
        }
        $order_list = $orders->paginate($this->per_page);
        $logistics_list = $logistic_list = LogisticsModel::OfStatus(1)->select(['id','name'])->get();
        return view('home/order.order', [
            'order_list' => $order_list,
            'tab_menu' => $this->tab_menu,
            'status' => '',
            'logistics_list' => $logistics_list,
            'name' => '',
            'per_page' => $this->per_page,
            'order_status' => $order_status,
            'order_number' => $order_number,
            'product_name' => $product_name,
            'sSearch' => true,
            'store_list' => $store_list,
            'products' => $products,
            'buyer_name' => $buyer_name,
            'buyer_phone' => $buyer_phone,
            'from_type' => $from_type,
        ]);

    }

    /**
     * 渠道人员销售订单列表
     * @param bool $bool 当为true是只可查询登陆用户
     */
    public function userSaleList(Request $request,$bool=false)
    {
        if($request->isMethod('get')){
            $time = $request->input('time');
            if($time){
                $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
            }else{
                $start_date = '2000-01-01 00:00:00';
            }
            $end_date = date("Y-m-d H:i:s");
        }

        if($request->isMethod('post')){
            $start_date = date("Y-m-d H:i:s",strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s",strtotime($request->input('end_date')));
        }

        //判断查询当前登陆用户 或 指定用户
        if($bool){
            $user_id = Auth::user()->id;
            //用户姓名
            $username = Auth::user()->realname;
            $post_url = url('/order/oneUserSaleList');
        }else{
            $user_id = $request->input('user_id_sales');
            //用户姓名
            $username = UserModel::find($user_id)->realname;
            $post_url = url('/order/userSaleList');
        }

        $order_list = OrderModel
            ::where('user_id_sales',$user_id)
            ->whereBetween('order_send_time', [$start_date, $end_date])
            ->paginate($this->per_page);
        $logistics_list = $logistic_list = LogisticsModel::OfStatus(1)->select(['id','name'])->get();

        //销售个人总金额
        $money_sum_obj = OrderModel
            ::select(DB::raw('sum(pay_money) as money_sum'))
            ->whereBetween('order_send_time', [$start_date, $end_date])
            ->where(['type' => 2, 'user_id_sales' => $user_id])
            ->where('status', '>', '8')->first();
        if($money_sum_obj){
            $money_sum = $money_sum_obj->money_sum?$money_sum_obj->money_sum:0;
        }else{
            $money_sum = 0;
        }

        return view('home/userSaleStatistics.show', [
            'order_list' => $order_list,
            'tab_menu' => $this->tab_menu,
            'logistics_list' => $logistics_list,
            'user_id_sales' => $user_id,
            'username' => $username,
            'money_sum' => $money_sum,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'post_url' => $post_url,
        ]);
    }

    /**
     * 查询当前用户销售明细
     *
     * @param Request $request
     */
    public function oneUserSaleList(Request $request)
    {
        return $this->userSaleList($request, true);
    }


    /**
     * 快递鸟发货实现
     *
     * @param Request $request
     * @return string
     */
    public function ajaxSendOrder(Request $request)
    {
        try {
            $order_id = (int)$request->input('order_id');
            $order_model = OrderModel::find($order_id);

            // 1、验证订单状态，仅待发货订单，才继续
            if ($order_model->status != 8 || $order_model->suspend == 1) {
                return ajax_json(0, 'error', '该订单不是待发货订单');
            }

            DB::beginTransaction();

            $order_model->send_user_id = Auth::user()->id;
            $order_model->order_send_time = date("Y-m-d H:i:s");

            if (!$order_model->changeStatus($order_id, 10)) {
                DB::rollBack();
                Log::error('Send Order ID:'. $order_id .'订单发货修改状态错误');
                return ajax_json(0, 'error', '订单发货修改状态错误');
            }

            // 创建出库单
            $out_warehouse = new OutWarehousesModel();
            if (!$out_warehouse->orderCreateOutWarehouse($order_id)) {
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货,创建出库单错误');
                return ajax_json(0,'error','订单发货,创建出库单错误');
            }

            //打印信息数据
            $printData = '';

            /**
             * 判断是否手动发货
             */
            $logistics_type = $request->input('logistics_type');
            //手动发货，获取快递公司ID  快递单号
            if($logistics_type == true){
                $logistics_id = $request->input('logistics_id');
                $logistics_no = $request->input('logistics_no');

            }else{
                // 调取菜鸟Api，获取快递单号，电子面单相关信息
                $kdniao = new KdniaoApi();
                $consignor_info = $kdniao->pullLogisticsNO($order_id);

                //如果电子面单获取失败
                if($consignor_info['Success'] === false){
                    DB::rollBack();
                    Log::error('Get cainiao, order id:'. $order_id . 'code:' . $consignor_info['ResultCode'] . $consignor_info['Reason']);
                    return ajax_json(0,'error：' . $consignor_info['ResultCode'] . $consignor_info['Reason']);
                }

                $Order = $consignor_info['Order'];
                $kdn_logistics_id = $Order['ShipperCode'];
                $logistics_no  = $Order['LogisticCode'];
                // 面单打印模板
                $printData = $consignor_info['PrintTemplate'];
                //将快递鸟物流代码转成本地物流ID
                $logisticsModel = LogisticsModel::where('kdn_logistics_id',$kdn_logistics_id)->first();
                if(!$logisticsModel){
                    DB::rollBack();
                    return ajax_json(0,'error','物流不存在');
                }
                $logistics_id = $logisticsModel->id;
            }



            //快递单号保存
            $order_model->express_no = $logistics_no;
            if(!$order_model->save()){
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单运单号保存失败');
                return ajax_json(0,'error','订单运单号保存失败');
            }

            //判断是否是平台同步的订单
            if($order_model->type == 3){
                // 订单发货同步到平台
                $job = (new PushExpressInfo($order_id, $logistics_id, $logistics_no))->onQueue('syncExpress');
                $this->dispatch($job);
            }

            DB::commit();

            return ajax_json(1,'ok',[
                'printData' => $printData,
                'waybillNO' => $logistics_no,
            ]);
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
        }
    }

    /**
     * 销售订单列表
     */
    public function salesOrderLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = OrderModel::query();
        $lists->where('type' , 2);
        $salesOrders = $lists->paginate($per_page);

        foreach ($salesOrders as $salesOrder)
        {
            $salesOrder->OrderLists($salesOrder);

        }

        return view('home/monitorLists.salesOrders', [
            'salesOrders' => $salesOrders,
        ]);
    }
    /**
     * 销售订单详情
     */
    public function showSalesOrders(Request $request)
    {
        $id = $request->input('id');
        $salesOrder = OrderModel::where('id' , $id)->where('type' , 2)->first();
        $orderSkuRelations = $salesOrder->orderSkuRelation;
        return view('home/monitorDetails.salesOrder', [
            'salesOrder' => $salesOrder,
            'orderSkuRelations' => $orderSkuRelations,
        ]);
    }

    /**
     * 电商销售订单列表
     */
    public function ESSalesOrdersLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = OrderModel::query();
        $lists->whereIn('type' , [3,5]);
        $ESSalesOrders = $lists->paginate($per_page);

        foreach ($ESSalesOrders as $ESSalesOrder)
        {
            $ESSalesOrder->OrderLists($ESSalesOrder);

        }
        return view('home/monitorLists.ESSalesOrders', [
            'ESSalesOrders' => $ESSalesOrders,
        ]);

    }

    /**
     * 电商销售订单详情
     */
    public function showESSalesOrders(Request $request)
    {
        $id = $request->input('id');
        $salesOrders = OrderModel::where('id' , $id)->first();
        $orderSkuRelations = OrderSkuRelationModel::where('order_id' , $id)->get();
        return view('home/monitorDetails.ESSalesOrder', [
            'salesOrder' => $salesOrders,
            'orderSkuRelations' => $orderSkuRelations,
        ]);
    }

    /**
     * 销售发票列表
     */
    public function salesInvoicesLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = OrderModel::query();
        $lists->where('type' , 2);
        $salesInvoices = $lists->paginate($per_page);

        foreach ($salesInvoices as $salesInvoice)
        {
            $salesInvoice->OrderLists($salesInvoice);

        }
        return view('home/monitorLists.salesInvoices', [
            'salesInvoices' => $salesInvoices,
        ]);

    }

    /**
     * 销售发票详情
     */
    public function showSalesInvoices(Request $request)
    {
        $id = $request->input('id');
        $salesOrder = OrderModel::where('id' , $id)->where('type' , 2)->first();
        $orderSkuRelations = $salesOrder->orderSkuRelation;

        return view('home/monitorDetails.salesInvoice', [
            'salesOrder' => $salesOrder,
            'orderSkuRelations' => $orderSkuRelations,
        ]);
    }

    /**
     * 配送列表
     */
    public function deliveriesLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = OrderModel::query();
        $deliveries = $lists->paginate($per_page);
        foreach ($deliveries as $delivery)
        {
            $delivery->OrderLists($delivery);

        }
        return view('home/monitorLists.deliveries', [
            'deliveries' => $deliveries,
        ]);
    }

    /**
     * 配送详情
     */
    public function showDeliveries(Request $request)
    {
        $id = $request->input('id');
        $delivery = OrderModel::where('id' , $id)->first();
        $orderSkuRelations = $delivery->orderSkuRelation;
        return view('home/monitorDetails.delivery', [
            'delivery' => $delivery,
            'orderSkuRelations' => $orderSkuRelations,
        ]);
    }

    // 获取代发供应商订单列表
    public function daifaSupplierOrderList(Request $request)
    {
        return OrderModel::supplierOrderList(5,'2017-10-10','2018-10-10');

    }

}
