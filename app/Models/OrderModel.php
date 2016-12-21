<?php
/**
 * 订单表
 */
namespace App\Models;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Jobs\ChangeSkuCount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
class OrderModel extends BaseModel
{
    use SoftDeletes, DispatchesJobs;

    protected $dates = ['deleted_at'];

    protected $appends = ['change_status'];

    /**
     * 关联模型到数据表
     *   id
     *   number
     *   outside_target_id
     *   type
     *   store_id
     *   user_id
     *   storage_id
     *   payment_type
     *   pay_money,total_money,discount_money
     *   count
     *   freight
     *   express_id,express_no
     *   buyer_name,buyer_tel,buyer_phone,buyer_zip,
     *   buyer_address,buyer_summary
     *   seller_summary
     *   summary
     *   status // 状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     *   suspend
     *   expired_time
     *   from_site,form_app
     *   created_at,updated_at
     * buyer_province	varchar(20)	是		省
     * buyer_city	varchar(20)	是		市
     * buyer_county	varchar(20)	是		县
     * buyer_township varchar(20) 是    镇
     * @var string
     */
    protected $table = 'order';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = ['type', 'store_id', 'payment_type', 'outside_target_id', 'express_id', 'freight', 'seller_summary', 'buyer_name', 'buyer_phone', 'buyer_tel', 'buyer_zip', 'buyer_address', 'user_id', 'status', 'total_money', 'discount_money', 'pay_money','number','count','storage_id','buyer_province','buyer_city','buyer_county','buyer_township','order_start_time','order_verified_time','order_send_time','order_user_id'];

    /**
     * 相对关联到商铺表
     */
    public function store()
    {
        return $this->belongsTo('App\Models\StoreModel', 'store_id');
    }

    /**
     * 相对关联到User用户表
     */
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    /**
     * 相对关联到物流表
     */
    public function logistics()
    {
        return $this->belongsTo('App\Models\LogisticsModel', 'express_id');
    }

    /**
     * 相对关联到仓库表
     */
    public function storage()
    {
        return $this->belongsTo('App\Models\StorageModel', 'storage_id');
    }

    /**
     * 相对关联调拨表
     */
    public function outWarehouses()
    {
        return $this->hasOne('App\Models\OutWarehousesModel', 'target_id');
    }

    /**
     * 一对一关联收款单表
     */
    public function receiveOrder()
    {
        return $this->hasOne('App\Models\ReceiveOrderModel', 'target_id');
    }

    /**
     * 一对一退款单
     */
    public function refundMoneyOrder()
    {
        return $this->hasOne('App\Models\RefundMoneyOrderModel', 'order_id');
    }
    
    /**
     * 一对多关联订单明细orderSkuRelation
     */
    public function orderSkuRelation()
    {
        return $this->hasMany('App\Models\OrderSkuRelationModel', 'order_id');
    }
    
    /**
     * 订单状态Status访问修改器   
     * 状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     *
     * @return string
     */
    public function getStatusValAttribute()
    {
        switch ($this->status) {
            case 0:
                $status = '已取消';
                break;
            case 1:
                $status = '待付款';
                break;
            case 5:
                $status = '待审核';
                break;
            case 8:
                $status = '待发货';
                break;
            case 10:
                $status = '已发货';
                break;
            case 20:
                $status = '已完成';
                break;
            default:
                $status = '已取消';
        }
        
        return $status;
    }

    /**
     * 付款类型访问修改器
     *
     * @param $key
     * @return string
     */
    public function getPaymentTypeAttribute($key)
    {
        switch ($key){
            case 1:
                $value = '在线付款';
                break;
            case 2:
                $value = '货到付款';
                break;
            default:
                $value = '在线付款';
        }
        
        return $value;
    }

    /**
     * 设置订单能否修改状态值 0:不可修改 1:可以修改
     */
    public function getChangeStatusAttribute()
    {
        //初始不能修改
        $status = 0;
        //当订单状态为 1/5 是可以修改订单信息
        if($this->status == 1 || $this->status == 5){
            $status = 1;
        }

        return (int)$status;
    }

    /**
     * 修改订单状态
     *
     * @param $order_id
     * @param $status
     * @return bool
     */
    public function changeStatus($order_id, $status)
    {
        $order_id = (int)$order_id;

        $status_arr = [0,1,5,8,10,20];
        if (!in_array($status, $status_arr)) {
            return false;
        }

        if (empty($order_id)) {
            return false;
        }
        if (!$order_model = self::find($order_id)) {
            return false;
        }
        $order_model->status = $status;
        if (!$order_model->save()) {
            return false;
        }
        
        return true;
    }

    /**
     * 订单挂起
     *
     * @return bool
     */
    public function suspend()
    {
        $this->suspend = 1;
        if (!$this->save()) {
            return false;
        }
        
        return true;
    }

    /**
     * 订单取消挂起
     *
     * @return bool
     */
    public function cancelSuspend()
    {
        $this->suspend = 0;
        if (!$this->save()) {
            return false;
        }
        
        return true;
    }

    /**
     * 从京东api拉取订单，同步到本地
     *
     * @param string $token  京东请求token
     * @param integer $storeId  店铺ID
     * @return bool
     */
    public function saveOrderList($token,$storeId)
    {
        //获取设置同步时间的缓存
        $endDateOrder = 'endDateOrder' . $storeId;
        if(Cache::has($endDateOrder)){
            $startDate = Cache::get($endDateOrder);
        }else{
            $startDate = date("Y-m-d H:i:s",time() - 12*3600);
        }
        $endDate = date("Y-m-d H:i:s");

        $jdSdk = new JdApi();
        if(!$order_info_list = $jdSdk->pullOrderList($token, $startDate,$endDate)){
            return false;
        }

        DB::beginTransaction();
        foreach ($order_info_list as $order_info){
            $order_model = new OrderModel();
            $order_model->number = CountersModel::get_number('DD');
            $order_model->outside_target_id = $order_info['order_id'];
            $order_model->type = 3;   //下载订单
            $order_model->store_id = $storeId;

            $StoreStorageLogisticModel = StoreStorageLogisticModel::where('store_id',$storeId)->first();
            if(!$StoreStorageLogisticModel){
                DB::roolBack();
                return false;
            }

            $order_model->storage_id = $StoreStorageLogisticModel->storage_id;    //暂时为1，待添加店铺默认仓库后，添加
            $order_model->payment_type = 1;
            $order_model->pay_money = $order_info['order_payment'];
            $order_model->total_money = $order_info['order_total_price'];
            $order_model->freight = $order_info['freight_price'];
            $order_model->discount_money = $order_info['seller_discount'];
            $order_model->express_id = $StoreStorageLogisticModel->logistics_id;   //暂时为1，添加店铺默认物流后添加
            $order_model->buyer_name = $order_info['consignee_info']['fullname'];
            $order_model->buyer_tel = $order_info['consignee_info']['telephone'];
            $order_model->buyer_phone = $order_info['consignee_info']['mobile'];
            $order_model->buyer_address = $order_info['consignee_info']['full_address'];
            $order_model->buyer_province = $order_info['consignee_info']['province'];
            $order_model->buyer_city = $order_info['consignee_info']['city'];
            $order_model->buyer_county = $order_info['consignee_info']['county'];
            $order_model->buyer_summary = $order_info['order_remark'];
            $order_model->order_start_time = $order_info['order_start_time'];
            $order_model->invoice_info = $order_info['invoice_info'];
//            $order_model->seller_summary = $order_info['vender_remark'];
            $order_model->status = 5;

            if(!$order_model->save()){
                DB::roolBack();
                return false;
            }

            $order_id = $order_model->id;

            //创建订单占货相关参数
            /*$storage_id_array = [];
            $sku_id_array = [];
            $sku_count = [];*/

            foreach ($order_info['item_info_list'] as $item_info){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_number = $item_info['outer_sku_id'];
                $order_sku_model->sku_name = $item_info['sku_name'];

                //根据sku 查询对应id
                if($skuModel = ProductsSkuModel::where('number',$item_info['outer_sku_id'])->first()){
                    $order_sku_model->sku_id = $skuModel->id;
                    $order_sku_model->product_id = $skuModel->product->id;

                    /*$sku_id_array[] = $skuModel->id;*/
                }else{
                    DB::rollBack();
                    $message = new PromptMessageModel();
                    if($item_info['outer_sku_id']){
                        $message->addMessage(1, 'erp系统：【' . $item_info['sku_name'] . '】 未添加SKU编码');
                    }else{
                        $message->addMessage(1, '京东平台：【' . $item_info['sku_name'] . '】 未添加SKU编码');
                    }
                    return false;
                }

                $order_sku_model->quantity = $item_info['item_total'];
                $order_sku_model->price = $item_info['jd_price'];
                $order_sku_model->discount = '';

                /*$sku_count[] = $item_info['item_total'];
                $storage_id_array = [$order_model->storage_id];*/
                
                //付款订单占货
                $productSkuModel = new ProductsSkuModel();
                if(!$productSkuModel->increasePayCount($skuModel->id, $item_info['item_total'])){
                    DB::rollBack();
                    return false;
                };

                if(!$order_sku_model->save()){
                    DB::rollBack();
                    return false;
                }
            }

            //创建订单时 增加付款占货量
            /*$storage_sku = new StorageSkuCountModel();
            if(!$storage_sku->increasePayCount($storage_id_array, $sku_id_array, $sku_count)){
                DB::rollBack();
                return false;
            }*/

            //同步库存任务队列
            /*$this->dispatch(new ChangeSkuCount($order_model));*/
        }

        DB::commit();
        Cache::forever($endDateOrder,$endDate);

        return true;
    }

    //同步自营商城待处理订单,保存到本地
    public function saveShopOrderList()
    {
        $store = StoreModel::where('platform',3)->first();

        if(!$store){
            Log::error('自营商城不存在');
            return false;
        }
        $storeId = $store->id;
        $shopApi = new ShopApi();
        $data = $shopApi->pullOderList();
        //如果获取列表失败
        if($data[0] === false){
            Log::error($data[1]);
            return false;
        }

        $order_list = $data[1];

        //遍历保存订单
        foreach ($order_list as $order){
            $count = OrderModel::where(['store_id' => $storeId,'outside_target_id' => $order['rid']])->count();
            if($count > 0){
                continue;
            }
            if($order['express_info'] === null){
                Log::warning('自营平台商店同步订单'. $order['rid'] .':express_info 字段：null');
                continue;
            }

            DB::beginTransaction();

            $order_model = new OrderModel();

            $order_model->number = CountersModel::get_number('DD');
            $order_model->outside_target_id = $order['rid'];
            $order_model->type = 3;   //下载订单
            $order_model->store_id = $storeId;

            $storeStorageLogistic = $store->storeStorageLogistic;

            if(!$storeStorageLogistic){
                Log::error('店铺未设置默认仓库或物流');
                DB::rollBack();
                return false;
            }

            $order_model->storage_id = $storeStorageLogistic->storage_id;    //暂时为1，待添加店铺默认仓库后，添加
            $order_model->payment_type = 1;
            $order_model->pay_money = $order['pay_money'];
            $order_model->total_money = $order['total_money'];
            $order_model->freight = $order['freight'];
            $order_model->discount_money = $order['discount_money'];
            $order_model->express_id = $storeStorageLogistic->logistics_id;   //暂时为1，添加店铺默认物流后添加
            $order_model->buyer_name = $order['express_info']['name'];
            $order_model->buyer_tel = '';
            $order_model->buyer_phone = $order['express_info']['phone'];
            $order_model->buyer_address = $order['express_info']['address'];
            $order_model->buyer_province = $order['express_info']['province'];
            $order_model->buyer_city = $order['express_info']['city'];
            if(key_exists('county',$order['express_info'])){
                $order_model->buyer_county = $order['express_info']['county'];
            }else{
                $order_model->buyer_county = '';
            }
            if(key_exists('town',$order['express_info'])){
                $order_model->buyer_township = $order['express_info']['town'];
            }else{
                $order_model->buyer_township = '';
            }
            $order_model->buyer_summary = '';
            $order_model->order_start_time = $order['created_at'];
            $order_model->invoice_info = $this->invoice($order['invoice_caty'],$order['invoice_title'] ,$order['invoice_content'] );
//            $order_model->seller_summary = $order_info['vender_remark'];
            $order_model->pec = $order['referral_code']?$order['referral_code'] : '';
            $order_model->from_site = $order['from_site'];
            $order_model->status = 5;
            $order_model->count = $order['items_count'];

            if(!$order_model->save()){
                DB::rollBack();
                Log::error('自营订单同步保存出错');
                return false;
            }
            $order_id = $order_model->id;

            //遍历保存订单商品明细
            foreach ($order['items'] as $item){
                if(!array_key_exists('number',$item)){
                    DB::rollBack();
                    continue 2;
                }
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_number = $item['number'];
                $order_sku_model->sku_name = $item['name'] . $item['sku_name'];

                //判断sku编码是否存在
                $message = new PromptMessageModel();
                if(empty($item['number'])){
                    DB::rollBack();
                    $message->addMessage(1, '自营平台：【' . $item['name'] . $item['sku_name'] . '】未添加SKU编码');
                    continue 2;
                }

                if($skuModel = ProductsSkuModel::where('number',$item['number'])->first()){

                    $order_sku_model->sku_id = $skuModel->id;
                    $order_sku_model->product_id = $skuModel->product->id;

                }else{
                    DB::rollBack();
                    $message->addMessage(1, 'erp系统：【' . $item['name'] . $item['sku_name'] . '】 未添加SKU编码');
                    continue 2;
                }

                $order_sku_model->quantity = $item['quantity'];
                $order_sku_model->price = $item['price'];
                $order_sku_model->discount = $item['price'] - $item['sale_price'];

                //增加付款占货量
                $productSkuModel = new ProductsSkuModel();
                if(!$productSkuModel->increasePayCount($skuModel->id, $item['quantity'])){
                    DB::rollBack();
                    Log::info('自营平台同步订单时增加付款占货出错');
                    continue 2;
                };
                
                if(!$order_sku_model->save()){
                    DB::rollBack();
                    Log::error('自营平台订单详细信息同步出错');
                    continue 2;
                }
            }

            DB::commit();

            //同步库存任务队列
            $this->dispatch(new ChangeSkuCount($order_model));
        }

    }


    /**
     * 自营店铺发票信息拼接
     *
     * @param $invoice_caty
     * @param $invoice_title
     * @param $invoice_content
     * @return string
     */
    public function invoice($invoice_caty, $invoice_title, $invoice_content)
    {
        switch ($invoice_caty) {
            case 1:
                $invoice_caty = '个人';
                break;
            case 2:
                $invoice_caty = '单位';
                break;
            default:
                $invoice_caty = '';
        }

        switch ($invoice_content) {
            case 'd':
                $invoice_content = '购买明细';
                break;
            case 'o':
                $invoice_content = '办公用品';
                break;
            case 's':
                $invoice_content = '数码配件';
                break;
            default:
                $invoice_content = '';
        }

        $str = '发票类型:' . $invoice_caty . '，' . '发票抬头：' . $invoice_title . '，' . '内容:' . $invoice_content . '。';
        
        return $str;
    }
    
    //更新未处理订单的状态
    public function autoChangeStatus()
    {
        $orderList = OrderModel::where(['type' => 3,'status' =>5 ])->orWhere(['type' => 3,'status' =>10 ])->get();
        foreach ($orderList as $order){
            $platform = $order->store->platform;

            switch ($platform){
                case 1:
                    //淘宝平台
                    break;
                case 2:
                    $this->changeJdOrderStatus($order->id);
                    break;
                case 3:
                    $this->changeShopOrderStatus($order->id);
                    break;
            }
        }
    }

    //更新京东未处理订单的状态
    protected function changeJdOrderStatus($order_id)
    {
        $api = new JdApi();
        $resp = $api->pullOrderStatus($order_id);

        if($resp->code != 0){
            return false;
        }
        if(!$status = $resp->order->orderInfo->order_state){
            return false;
        }

        switch ($status){
            case 'WAIT_GOODS_RECEIVE_CONFIRM':
                $status = 10;  //已发货
                break;
            case 'FINISHED_L':
                $status = 20;  //完成
                break;
            case 'TRADE_CANCELED':
                $status = 0;  //取消
                break;
            default:
                return false;
        }
        $this->changeStatus($order_id, $status);
    }

    //更新自营平台未处理订单状态
    protected function changeShopOrderStatus($order_id)
    {
        $orderModel = OrderModel::find($order_id);
        if(!$orderModel){
            return false;
        }
        $shopApi = new ShopApi();
        $result = $shopApi->getOrderInfo($orderModel->outside_target_id);
        if($result['success'] == false){
            return false;
        }

        $status = $result['data']['status'];
        //自营商城订单状态: 0. 已取消;1.待付款；10.待发货(可以申请退款)；12.退款中；13.退款成功；15.待收货；16.待评价；20.订单完成；
        //erp 状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
        switch ($status){
            case 0:
                $status = 0;
                break;
            case 1:
                $status = 1;
                break;
            case 10:
                $status = 5;
                break;
            case 12:
                $status = 5;
                break;
            case 13:
                $status = 5;
                break;
            case 15:
                $status = 10;
                break;
            case 16:
                $status = 20;
                break;
            case 20:
                $status = 20;
                break;
        }
        $this->changeStatus($order_id, $status);
    }


    /**
     * 待发货订单数量
     *
     * @return mixed
     */
    public static function sendOrderCount()
    {
        $count = self::where(['status' => 8, 'suspend' => 0])->count();
        return $count;
    }

    /**
     * 拆单
     *
     * @param $data
     * @return array
     */
    public function splitOrder($data){
        $order_id = $data[0]['order_id'];
        $order_info = OrderModel::find($order_id);
        if(!$order_info){
            return [false,'code error'];
        }

        try{

            DB::beginTransaction();

            //父订单要减去的金额
            $moneySum = 0;
            //父订单要减去的数量
            $productSum = 0;

            //创建新拆分的订单 修改原定订单明细的order_id 为新拆订单ID
            foreach ($data as $v){

                $new_order = new OrderModel();
                $new_order->number = $v['number'];
                $new_order->outside_target_id = $order_info->outside_target_id;
                $new_order->type = $order_info->type;   //下载订单
                $new_order->store_id = $order_info->store_id;
                $new_order->storage_id = $order_info->storage_id;
                $new_order->payment_type = $order_info->payment_type;
                $new_order->pay_money = 0;
                $new_order->total_money = 0;
                $new_order->freight = 0;
                $new_order->discount_money = 0;
                $new_order->express_id = $order_info->express_id;
                $new_order->buyer_name = $order_info->buyer_name;
                $new_order->buyer_tel = '';
                $new_order->buyer_phone = $order_info->buyer_phone;
                $new_order->buyer_address = $order_info->buyer_address;
                $new_order->buyer_province = $order_info->buyer_province;
                $new_order->buyer_city = $order_info->buyer_city;
                $new_order->buyer_county = $order_info->buyer_county;
                $new_order->buyer_township = $order_info->buyer_township;
                $new_order->buyer_county = '';
                $new_order->buyer_summary = '';
                $new_order->order_start_time = $order_info->order_start_time;
                $new_order->invoice_info = $order_info->invoice_info;
//            $order_model->seller_summary = $order_info['vender_remark'];
                $new_order->pec = $order_info->pec;
                $new_order->from_site = $order_info->from_site;
                $new_order->status = 5;
                $new_order->split_status = 1;
                if(!$new_order->save()){
                    DB::rollBack();
                    return [false,'new splitOrder save error'];
                }

                //新拆订单总金额
                $moneyCount = 0;
                //新拆订单总数量
                $productCount = 0;
                //将明细的order_id 改为新拆订单的ID
                foreach ($v['arr_id'] as $details_id){
                    $details_info = OrderSkuRelationModel::find($details_id);
                    if(!$details_info){
                        DB::rollBack();
                        return [false,'details_id error'];
                    }
                    $moneyCount += $details_info->price * $details_info->quantity;
                    $productCount += $details_info->quantity;
                    $details_info->order_id = $new_order->id;
                    if(!$details_info->save()){
                        DB::rollBack();
                        return [false, 'save new splitOrder error'];
                    }
                }

                $moneySum += $moneyCount;
                $productSum += $productCount;

                $new_order->total_money = $moneyCount;
                $new_order->pay_money = $moneyCount;
                $new_order->count = $productCount;
                if(!$new_order->save()){
                    DB::rollBack();
                    return false;
                }
            }

            //修改原订单信息
            $order_info->total_money = $order_info->total_money - $moneySum;
            $order_info->pay_money = $order_info->pay_money - $moneySum;
            $order_info->count = ($order_info->count - $productSum > 0)?($order_info->count - $productSum) : 0;
            $order_info->split_status = 1;
            if(!$order_info->save()){
                DB::rollBack();
                return [false, 'edit order error'];
            }

            //如果是自营平台订单拆单，同步至自营平台
            if($order_info->store->platform == 3){
                $array = [];
                $order_data = OrderModel::where('outside_target_id',$order_info->outside_target_id)->get();
                //拼接拆单参数
                foreach ($order_data as $v){
                    $items = [];
                    foreach ($v->orderSkuRelation as $k){
                        $items[] = $k->sku_number;
                    }

                    $array[] = ['id' => $v->number, 'items' => $items];
                }
                $shopApi = new ShopApi();
                $result = $shopApi->postSplitOrderInfo($order_info->outside_target_id, json_encode($array));
                if($result['success'] == false){
                    DB::rollBack();
                    return [false,$result['message']];
                }
            }

            DB::commit();
            return [true,'ok'];
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            return [false,'exception error'];
        }

    }
    
    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            RecordsModel::addRecord($obj, 1, 12);

        });

        self::deleted(function ($obj)
        {
            RecordsModel::addRecord($obj, 3, 12);
        });

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            if(array_key_exists('status', $remark)){
                $status = $remark['status'];
                switch ($status){
                    case 8:
                        RecordsModel::addRecord($obj, 4, 12);
                        break;
                    case 5:
                        RecordsModel::addRecord($obj, 5, 12);
                        break;
                    case 10:
                        RecordsModel::addRecord($obj, 6, 12);
                        break;
                }
            }else{
                RecordsModel::addRecord($obj, 2, 12,$remark);
            }

        });
    }
}
