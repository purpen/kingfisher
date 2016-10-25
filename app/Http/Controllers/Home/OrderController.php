<?php

namespace App\Http\Controllers\Home;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Http\Controllers\KdniaoController;
use App\Http\Requests\UpdateOrderRequest;
use App\Jobs\ChangeSkuCount;
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
     * 订单查询.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_list = OrderModel::orderBy('id','desc')->paginate(20);
        return view('home/order.order',['order_list' => $order_list]);
    }

    /**
     * 未付款订单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nonOrderList(){
        $order_list = OrderModel::where(['status' => 1,'suspend' => 0])->orderBy('id','desc')->paginate(20);
        return view('home/order.nonOrder',['order_list' => $order_list]);
    }

    /**
     * 待审核订单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verifyOrderList(){
        $order_list = OrderModel::where(['status' => 5,'suspend' => 0])->orderBy('id','desc')->paginate(20);
        return view('home/order.verifyOrder',['order_list' => $order_list]);
    }

    /**
     * 反审订单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reversedOrderList(){
        $order_list = OrderModel::where(['status' => 8,'suspend' => 0])->orderBy('id','desc')->paginate(20);
        return view('home/order.reversedOrder',['order_list' => $order_list]);
    }

    /**
     * 待打印发货列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendOrderList(){
        $order_list = OrderModel::where(['status' => 8,'suspend' => 0])->orderBy('id','desc')->paginate(20);
        return view('home/order.sendOrder',['order_list' => $order_list]);
    }

    /**
     * 已发货列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function completeOrderList(){
        $order_list = OrderModel::where(['status' => 10,'suspend' => 0])->orWhere(['status' => 20,'suspend' => 0])->orderBy('id','desc')->paginate(20);
        return view('home/order.completeOrder',['order_list' => $order_list]);
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
        return view('home/order.createOrder',['storage_list' => $storage_list, 'store_list' => $store_list,'logistic_list' => $logistic_list]);
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
    public function ajaxEdit(Request $request){
        $order_id = (int)$request->input('id');
        if(empty('id')){
            return ajax_json(0,'error');
        }
        $order = OrderModel::find($order_id); //订单

        $order->logistic_name = $order->logistics->name;
        /*$order->storage_name = $order->storage->name;*/

        $order_sku = OrderSkuRelationModel::where('order_id',$order_id)->get();

        $product_sku_model = new ProductsSkuModel();
        $order_sku = $product_sku_model->detailedSku($order_sku); //订单明细

        $storage_list = StorageModel::select('id','name')->where('status',1)->get();   //仓库
        $logistic_list = LogisticsModel::select('id','name')->where('status',1)->get();  //物流

        $data = ['order' => $order,'order_sku' => $order_sku,'storage_list' => $storage_list,'logistic_list' => $logistic_list];
        return ajax_json(1,'ok',$data);
    }

    /**
     * 修改订单信息
     * @param Request $request
     * @return string
     */
    public function ajaxUpdate(UpdateOrderRequest $request){
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
     * @param Request $request
     * @return string
     */
    public function ajaxDestroy(Request $request){
        $order_id = (int)$request->input('order_id');
        if(empty($order_id)){
            return ajax_json(0,'error');
        }
        try{
            DB::beginTransaction();
            $order_model = OrderModel::find($order_id);
            if(!$order_model){
                DB::rollBack();
                return ajax_json(0,'error');
            }
            switch ($order_model->status){
                case '待付款':
                    $storage_sku_count = new StorageSkuCountModel();
                    if(!$storage_sku_count->decreaseReserveCount($order_id)){
                        DB::rollBack();
                        return ajax_json(0,"内部错误");
                    }
                    break;
                case '待审核':
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
            if(!$order_model->delete()){
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
     * @param array $order_id_array
     * @return string
     */
    public function ajaxVerifyOrder(Request $request){
        $order_id_array = $request->input('order');
        $order_model = new OrderModel();
        foreach ($order_id_array as $order_id){
            if(!$order_model->changeStatus($order_id, 8)){
                return ajax_json(0,'error');
            }
        }
        return ajax_json(1,'ok');
    }

    /**
     * 批量反审订单
     * @param array $order_id_array
     * @return string
     */
    public function ajaxReversedOrder(Request $request){
        $order_id_array = $request->input('order');
        $order_model = new OrderModel();
        foreach ($order_id_array as $order_id){
            if(!$order_model->changeStatus($order_id, 5)){
                return ajax_json(0,'error');
            }
        }
        return ajax_json(1,'ok');
    }

    /**
     * 打印发货订单
     * @param array $order_id_array
     * @return string
     */
    public function ajaxSendOrder(Request $request){
        try{
            $order_id = $request->input('order');
//            $order_model = new OrderModel();
            $order_model = OrderModel::find($order_id);
            DB::beginTransaction();
            if(!$order_model->changeStatus($order_id, 10)){
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货修改状态错误');
                return ajax_json(0,'error','订单发货修改状态错误');
            }

            //创建出库单
            $out_warehouse = new OutWarehousesModel();
            if(!$out_warehouse->orderCreateOutWarehouse($order_id)){
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货,创建出库单错误');
                return ajax_json(0,'error','订单发货,创建出库单错误');
            }

            //修改付款占货数
            $storage_sku_count = new StorageSkuCountModel();
            if(!$storage_sku_count->decreasePayCount($order_id)){
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货修改付款占货比错误');
                return ajax_json(0,'error','订单发货修改付款占货比错误');
            }

            //创建订单收款单
            $model = new ReceiveOrderModel();
            if(!$model->orderCreateReceiveOrder($order_id)){
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货创建订单收款单错误');
                return ajax_json(0,'error','订单发货创建订单收款单错误');
            }
            
            //调取快递鸟Api，获取快递单号，电子面单相关信息
            $kdniao = new KdniaoController();
            $consignor_info = $kdniao->pullLogisticsNO($order_id);
            if(!$consignor_info['Success']){
                DB::rollBack();
                Log::error('ID:'. $order_id . $consignor_info['ResultCode']);
                return ajax_json(0,'error',$consignor_info['ResultCode'] . $consignor_info['Reason']);
            }
            $kdn_logistics_id = $consignor_info['Order']['ShipperCode'];
            $logistics_no  = $consignor_info['Order']['LogisticCode'];
            //面单打印模板
            $PrintTemplate = $consignor_info['PrintTemplate'];

            //将快递鸟物流代码转成本地物流ID
            $logisticsModel = LogisticsModel::where('kdn_logistics_id',$kdn_logistics_id)->first();
            if(!$logisticsModel){
                return ajax_json(0,'error','物流不存在');
            }
            $logistics_id = $logisticsModel->id;

            //订单发货同步到平台
            if(!$this->pushOrderSend($order_id,[$logistics_id], [$logistics_no])){
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货创建错误');
                return ajax_json(0,'error','订单发货创建错误');
            }
            
            DB::commit();

            //同步库存任务队列
            $this->dispatch(new ChangeSkuCount($order_model));
            return ajax_json(1,'ok',$PrintTemplate);
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
        }
    }

    /**
     * 通过sku编号或商品名称 搜索指定仓库的中的sku信息
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
