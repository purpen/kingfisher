<?php

namespace App\Http\Controllers\Home;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Helper\KdniaoApi;
use App\Http\Requests\UpdateOrderRequest;
use App\Jobs\ChangeSkuCount;
use App\Models\ChinaCityModel;
use App\Models\CountersModel;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsSkuModel;
use App\Models\ReceiveOrderModel;
use App\Models\RefundMoneyOrderModel;
use App\Models\StorageModel;
use App\Models\StorageSkuCountModel;
use App\Models\StoreModel;
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
        if ($status === 'all') {
            $order_list = OrderModel::orderBy('id','desc')->paginate($this->per_page);
        } else {
            $order_list = OrderModel::where(['status' => $status, 'suspend' => 0])->orderBy('id','desc')->paginate($this->per_page);
        }
        
        return view('home/order.order', [
            'order_list' => $order_list,
            'tab_menu' => $this->tab_menu,
            'status' => $status,
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
    public function servicingOrderList()
    {
        $order_list = OrderModel::where(['suspend' => 1])->orderBy('id','desc')->paginate($this->per_page);

        return view('home/order.order', [
            'order_list' => $order_list,
            'tab_menu' => 'servicing',
            'status' => '',
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
        $storage_list = StorageModel::select('id','name')->where('status',1)->get();

        $store_list = StoreModel::select('id','name')->get();

        $logistic_list = LogisticsModel::select('id','name')->where('status',1)->get();

        $china_city = ChinaCityModel::where('layer',1)->get();
        
        return view('home/order.createOrder', [
            'storage_list' => $storage_list, 
            'store_list' => $store_list,
            'logistic_list' => $logistic_list,
            'china_city' => $china_city
        ]);
    }
    
    public function ajaxOrder(Request $request){
        return ajax_json(1,'ok');
    }

    /**
     * 获取指定仓库sku列表
     * @param Request $request
     * @return string
     */
    public function ajaxSkuList(Request $request){
        $storage_id = (int)$request->input('id');
        if(empty($storage_id)){
            return ajax_json(0,'参数错误');
        }
        $storage_sku_model = new StorageSkuCountModel();
        $sku_list = $storage_sku_model->skuList($storage_id);
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

            $storage_sku = new StorageSkuCountModel();
            if(!$storage_sku->isCount($all['sku_storage_id'], $all['sku_id'], $all['quantity'])){
                return "仓库库存不足";
            }

            $total_money = 0.00;
            $discount_money = 0.00;
            $count = 0;
            for($i=0;$i<count($all['quantity']);$i++){
                $total_money += $all['quantity'][$i] * $all['price'][$i] * 100;
                $discount_money += $all['discount'][$i];
                $count += $all['quantity'][$i];
            }


            $all = $request->except(['sku_id','sku_storage_id','price','quantity','discount']);
            $all['user_id'] = Auth::user()->id;
            $all['status'] = 5;
            $all['total_money'] = $total_money/100;
            $all['discount_money'] = $discount_money;
            $all['pay_money'] = ($total_money/100) + $all['freight'] - $discount_money;
            $all['count'] = $count;
            
            $number = CountersModel::get_number('DD');
            $all['number'] = $number;

            $all['buyer_province'] = ChinaCityModel::where('oid',$request->input('province_id'))->first()->name;
            $all['buyer_city'] = ChinaCityModel::where('oid',$request->input('city_id'))->first()->name;
            $all['buyer_county'] = ChinaCityModel::where('oid',$request->input('county_id'))->first()->name;

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
                $order_sku_model->product_id = $product_sku_model->product->id;
                $order_sku_model->quantity = $all['quantity'][$i];
                $order_sku_model->price = $all['price'][$i];
                $order_sku_model->discount = $all['discount'][$i];
                if(!$order_sku_model->save()){
                    DB::rollBack();
                    return '参数错误';
                }
            }

            if(!$storage_sku->increasePayCount($all['sku_storage_id'], $all['sku_id'], $all['quantity'])){
                DB::rollBack();
                return '付款占货关联操作失败';
            }

            DB::commit();
            return redirect('/order');
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

        $order->logistic_name = $order->logistics->name;
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
        
        return ajax_json(1, 'ok', [
            'order' => $order,
            'order_sku' => $order_sku,
            'storage_list' => $storage_list,
            'logistic_list' => $logistic_list
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
     * 删除未付款，付款待审核订单
     *
     * @param Request $request
     * @return string
     */
    public function ajaxDestroy(Request $request)
    {
        $order_id = (int)$request->input('order_id');
        if(empty($order_id)){
            return ajax_json(0,'参数错误');
        }
        try{
            DB::beginTransaction();
            $order_model = OrderModel::find($order_id);
            if(!$order_model){
                return ajax_json(0,'订单不存在');
            }

            if($order_model->status != 1 && $order_model->status != 5){
                return ajax_json(0,'该订单已审核 不能取消');
            }

            switch ($order_model->status){
                case 1:
                    $storage_sku_count = new StorageSkuCountModel();
                    if(!$storage_sku_count->decreaseReserveCount($order_id)){
                        DB::rollBack();
                        return ajax_json(0,"内部错误");
                    }
                    break;
                case 5:
                    $storage_sku_count = new StorageSkuCountModel();
                    if(!$storage_sku_count->decreasePayCount($order_id)){
                        DB::rollBack();
                        return ajax_json(0,"内部错误");
                    }
                    break;
                default:
                    DB::rollBack();
                    return "内部错误";
            }

            if(!$order_model->changeStatus($order_id, 0)){
                DB::rollBack();
                return ajax_json(0,'error');
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
            $storage_id_arr = [];
            $sku_id_arr = [];
            $sku_count_arr = [];
            foreach ($order_sku as $sku){
                $storage_id_arr[] = $order_model->storage_id;
                $sku_id_arr[] = $sku->sku_id;
                $sku_count_arr[] = $sku->quantity;
            }
            $storage_sku = new StorageSkuCountModel();
            if(!$storage_sku->isCount($storage_id_arr, $sku_id_arr, $sku_count_arr)){
                DB::rollBack();
                return ajax_json(0,'发货商品所选仓库库存不足');
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

            // 修改付款占货数
            $storage_sku_count = new StorageSkuCountModel();
            if (!$storage_sku_count->decreasePayCount($order_id)) {
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货修改付款占货比错误');
                return ajax_json(0,'error','订单发货修改付款占货比错误');
            }

            // 创建订单收款单
            $model = new ReceiveOrderModel();
            if (!$model->orderCreateReceiveOrder($order_id)) {
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货创建订单收款单错误');
                return ajax_json(0,'error','订单发货创建订单收款单错误');
            }
            
            // 调取快递鸟Api，获取快递单号，电子面单相关信息
            $kdniao = new KdniaoApi();
            $consignor_info = $kdniao->pullLogisticsNO($order_id);
            print_r($consignor_info);
            if (!$consignor_info['Success']) {
                DB::rollBack();
                Log::error('Get kdniao, order id:'. $order_id . $consignor_info['ResultCode']);
                return ajax_json(0,'error',$consignor_info['ResultCode'] . $consignor_info['Reason']);
            }
            $kdn_logistics_id = $consignor_info['Order']['ShipperCode'];
            $logistics_no  = $consignor_info['Order']['LogisticCode'];
            // 面单打印模板
            $PrintTemplate = $consignor_info['PrintTemplate'];

            //将快递鸟物流代码转成本地物流ID
            $logisticsModel = LogisticsModel::where('kdn_logistics_id',$kdn_logistics_id)->first();
            if(!$logisticsModel){
                DB::rollBack();
                return ajax_json(0,'error','物流不存在');
            }
            $logistics_id = $logisticsModel->id;

            //判断是否是平台同步的订单
            if($order_model->type == 3){
                //订单发货同步到平台
                if(!$this->pushOrderSend($order_id,[$logistics_id], [$logistics_no])){
                    DB::rollBack();
                    Log::error('ID:'. $order_id .'订单发货创建错误');
                    return ajax_json(0,'error','订单发货创建错误');
                }
            }

            
            DB::commit();
            
            return ajax_json(1,'ok',$PrintTemplate);
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
        $where = $request->input('where');
        $storage_sku_count = new StorageSkuCountModel();
        $sku_list = $storage_sku_count->search($storage_id, $where);
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
    public function pushOrderSend($order_id, $logistics_id=[], $waybill=[])
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
}
