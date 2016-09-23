<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\UpdateOrderRequest;
use App\Models\CountersModel;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsSkuModel;
use App\Models\ReceiveOrderModel;
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
        $order_list = OrderModel::where(['status' => 10,'suspend' => 0])->orderBy('id','desc')->paginate(20);
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
        $order->storage_name = $order->storage->name;

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
     * 批量打印发货订单
     * @param array $order_id_array
     * @return string
     */
    public function ajaxSendOrder(Request $request){
        try{
            $order_id_array = $request->input('order');
            $order_model = new OrderModel();
            DB::beginTransaction();
            foreach ($order_id_array as $order_id){
                if(!$order_model->changeStatus($order_id, 10)){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }

                $out_warehouse = new OutWarehousesModel();
                if(!$out_warehouse->orderCreateOutWarehouse($order_id)){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }

                $storage_sku_count = new StorageSkuCountModel();
                if(!$storage_sku_count->decreasePayCount($order_id)){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }
                $model = new ReceiveOrderModel();
                if(!$model->orderCreateReceiveOrder($order_id)){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }
            }
            DB::commit();
            return ajax_json(1,'ok');
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


    //从京东api拉取订单，同步到本地
    public function pullOrderList($token,$storeId)
    {
        //同步时间缓存
        $endDateOrder = 'endDateOrder' . $storeId;
        if(Cache::has($endDateOrder)){
         $startDate = Cache::get($endDateOrder);
        }else{
         $startDate = date("Y-m-d H:i:s",time() - 12*3600);
        }
        $endDate = date("Y-m-d H:i:s");

        $jdSdk = new JdSdkController();
        $resp = $jdSdk->pullOrder($token, $startDate,$endDate);

        dd($resp);

        $order_info_list = $resp['360buy_order_search_response']['orderSearchResponse']['order_search']['order_info_list'];
        
        DB::beginTransaction();
        foreach ($order_info_list as $order_info){
            $order_model = new OrderModel();
            $order_model->number = CountersModel::get_number('DD');
            $order_model->outside_target_id = $order_info['order_id'];
            $order_model->type = 3;   //下载订单
            $order_model->order_id = $storeId;
            $order_model->storage_id = 0;    //暂时为0，待添加店铺默认仓库后，添加
            $order_model->payment_type = 1;
            $order_model->pay_money = $order_info['order_payment '];
            $order_model->total_money = $order_info['order_total_price'];
            $order_model->freight = $order_info['freight_price'];
            $order_model->discount_money = $order_info['seller_discount'];
            $order_model->express_id = $order_info['logistics_id'];
            $order_model->buyer_name = $order_info['consignee_info']['fullname'];
            $order_model->buyer_tel = $order_info['consignee_info']['telephone'];
            $order_model->buyer_phone = $order_info['consignee_info']['mobile'];
            $order_model->buyer_address = $order_info['consignee_info']['full_address'];
            $order_model->buyer_summary = $order_info['order_remark'];
            $order_model->seller_summary = $order_info['vender_remark'];
            
            if(!$order_model = $order_model->save()){
                DB::roolBack();
                return false;
            }
            $order_id = $order_model->id;
            foreach ($order_info['item_info_list'] as $item_info){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_number = $item_info['outer_sku_id'];
                $order_sku_model->product_id = '';        //暂时为空
                $order_sku_model->quantity = $item_info['item_total '];
                $order_sku_model->price = $item_info['jd_price'];
                $order_sku_model->discount = '';
                if(!$order_sku_model->save()){
                    DB::rollBack();
                    return false;
                }
            }
            
        }

        DB::commit();
        Cache::forever($endDateOrder,$endDate);
        return true;
    }

    public function test1(){
         $this->pullOrderList('8f0df5b8-f38b-462d-9aaf-fe2b7c22b6da',3);
    }
}
