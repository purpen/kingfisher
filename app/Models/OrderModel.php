<?php
/**
 * 订单表
 */

namespace App\Models;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Jobs\ChangeSkuCount;
use App\Jobs\PushExpressInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Maatwebsite\Excel\Facades\Excel;


class OrderModel extends BaseModel
{
    use SoftDeletes, DispatchesJobs;

    protected $dates = ['deleted_at'];

    protected $appends = ['change_status', 'form_app_val', 'type_val'];

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
     * buyer_province    varchar(20)    是        省
     * buyer_city    varchar(20)    是        市
     * buyer_county    varchar(20)    是        县
     * buyer_township varchar(20) 是    镇
     * @var string
     */
    protected $table = 'order';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = ['type', 'financial_name', 'financial_time', 'payment_time', 'store_id', 'payment_type', 'outside_target_id', 'express_id', 'freight', 'buyer_summary', 'seller_summary', 'buyer_name', 'buyer_phone', 'buyer_tel', 'buyer_zip', 'buyer_address', 'user_id', 'status', 'total_money', 'discount_money', 'pay_money', 'number', 'count', 'storage_id', 'buyer_province', 'buyer_city', 'buyer_county', 'buyer_township', 'order_start_time', 'order_verified_time', 'order_send_time', 'order_user_id', 'user_id_sales', 'express_no', 'payment_type', 'random_id', 'invoice_info', 'excel_type', 'invoice_type', 'invoice_header', 'invoice_added_value_tax', 'invoice_ordinary_number', 'from_type', 'distributor_id', 'address_id', 'voucher_id'];

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
     * 相对关联出库表
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
     * 一对一关联供应商
     */
    public function supplier()
    {
        return $this->hasOne('App\Models\SupplierModel', 'supplier_id');
    }

    /**
     * 一对一关联经销商
     */
    public function distributor()
    {
        return $this->belongsTo('App\Models\DistributorModel', 'distributor_id');
    }

    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel', 'voucher_id');
    }

    /**
     * 相对关联到address表
     */
    public function address()
    {
        return $this->belongsTo('App\Models\AddressModel', 'address_id');
    }

    /**
     * 相对关联到发票历史表表
     */
    public function historyInvoice()
    {
        return $this->belongsTo('App\Models\HistoryInvoiceModel', 'order_id');
    }

    /**
     * 相对关联到发票历史表表
     */
    public function OrderVoucher()
    {
        return $this->belongsTo('App\Models\OrderModel', 'prove_id');
    }


    /**
     *  获取经销商银行转账凭证图片
     */
    public function getProveAttribute()
    {
        $result = $this->imageFile();
        if (is_object($result)) {
            return $result->small;
        }
        return $result;
    }

    /**
     * 获取商品图片信息对象
     *
     */
    public function imageFile()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 23])
            ->orderBy('id', 'desc')
            ->first();
        if (empty($asset)) {
            return url('images/default/erp_product1.png');
        }

        return $asset->file;
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
            case 6:
                $status = '待财务审核';
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
        switch ($key) {
            case 1:
                $value = '在线付款';
                break;
            case 2:
                $value = '货到付款';
                break;
            case 3:
                $value = '账期';
                break;
            case 4:
                $value = '公司月结';
                break;
            case 5:
                $value = '现结';
                break;
            case 6:
                $value = '公司转账';
                break;
            default:
                $value = '在线付款';
        }

        return $value;
    }

    // 物流阶段访问修改器
    public function getExpressStateValueAttribute()
    {
        $state = config('express.state');
        if (array_key_exists($this->express_state, $state)) {
            return $state[$this->express_state];
        } else {
            return '无';
        }
    }

    // 物流详情访问修改器
    public function getExpressContentValueAttribute()
    {
        if ($this->express_content) {
            return (array)explode('&', $this->express_content);
        } else {
            return [];
        }
    }

    /**
     * 设置订单能否修改状态值 0:不可修改 1:可以修改
     */
    public function getChangeStatusAttribute()
    {
        //初始不能修改
        $status = 0;
        //当订单状态为 1/5 是可以修改订单信息
        if ($this->status == 1 || $this->status == 5) {
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
        # 传入参数$order_id为对象时
        if ($order_id instanceof OrderModel && !empty($order_id->id)) {
            $order_model = $order_id;
        } else {                        # 参数order_id不是对象时
            $order_id = (int)$order_id;

            $status_arr = [0, 1, 5, 6, 8, 10, 20];
            if (!in_array($status, $status_arr)) {
                return false;
            }

            if (empty($order_id)) {
                return false;
            }
            if (!$order_model = self::find($order_id)) {
                return false;
            }
        }
        if ($status == $order_model->status) {
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
     * @param string $token 京东请求token
     * @param integer $storeId 店铺ID
     * @return bool
     */
    public function saveOrderList($token, $storeId)
    {
        //获取设置同步时间的缓存
        $endDateOrder = 'endDateOrder' . $storeId;
        if (Cache::has($endDateOrder)) {
            $startDate = Cache::get($endDateOrder);
        } else {
            $startDate = date("Y-m-d H:i:s", time() - 12 * 3600);
        }
        $endDate = date("Y-m-d H:i:s");

        $jdSdk = new JdApi();
        if (!$order_info_list = $jdSdk->pullOrderList($token, $startDate, $endDate)) {
            return false;
        }

        DB::beginTransaction();
        foreach ($order_info_list as $order_info) {
            $order_model = new OrderModel();
            $order_model->number = CountersModel::get_number('DD');
            $order_model->outside_target_id = $order_info['order_id'];
            $order_model->type = 3;   //下载订单
            $order_model->store_id = $storeId;

            $StoreStorageLogisticModel = StoreStorageLogisticModel::where('store_id', $storeId)->first();
            if (!$StoreStorageLogisticModel) {
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

            if (!$order_model->save()) {
                DB::roolBack();
                return false;
            }

            $order_id = $order_model->id;

            foreach ($order_info['item_info_list'] as $item_info) {
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_number = $item_info['outer_sku_id'];
                $order_sku_model->sku_name = $item_info['sku_name'];

                //根据sku 查询对应id
                if ($skuModel = ProductsSkuModel::where('number', $item_info['outer_sku_id'])->first()) {
                    $order_sku_model->sku_id = $skuModel->id;
                    $order_sku_model->product_id = $skuModel->product->id;

                } else {
                    DB::rollBack();
                    $message = new PromptMessageModel();
                    if ($item_info['outer_sku_id']) {
                        $message->addMessage(1, 'erp系统：【' . $item_info['sku_name'] . '】 未添加SKU编码');
                    } else {
                        $message->addMessage(1, '京东平台：【' . $item_info['sku_name'] . '】 未添加SKU编码');
                    }
                    return false;
                }

                $order_sku_model->quantity = $item_info['item_total'];
                $order_sku_model->price = $item_info['jd_price'];
                $order_sku_model->discount = '';

                //判断可卖库存是否足够此订单
                $productSkuModel = new ProductsSkuModel();
                $quantity = $productSkuModel->sellCount($skuModel->id);
                if ($item_info['item_total'] > $quantity) {
                    DB::rollBack();
                    $message = new PromptMessageModel();
                    $message->addMessage(2, 'erp系统：【' . $item_info['sku_name'] . '】 库存不足');
                    return false;
                }

                //付款订单占货
                $productSkuModel = new ProductsSkuModel();
                if (!$productSkuModel->increasePayCount($skuModel->id, $item_info['item_total'])) {
                    DB::rollBack();
                    return false;
                };

                if (!$order_sku_model->save()) {
                    DB::rollBack();
                    return false;
                }
            }

            // 创建订单收款单
            $model = new ReceiveOrderModel();
            if (!$model->orderCreateReceiveOrder($order_id)) {
                DB::rollBack();
                Log::error('ID:' . $order_id . '订单发货创建订单收款单错误');
                return false;
            }

            //同步库存任务队列
            /*
            $job = (new ChangeSkuCount($order_model))->onQueue('syncStock');
            $this->dispatch($job);*/
        }

        DB::commit();
        Cache::forever($endDateOrder, $endDate);

        return true;
    }

    //同步自营商城待处理订单,保存到本地
    /*public function saveShopOrderList()
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

            $storeStorageLogistic = $store->storeStorageLogistic;

            if(!$storeStorageLogistic){
                Log::error('店铺未设置默认仓库或物流');
                DB::rollBack();
                return false;
            }

            DB::beginTransaction();
            $order_model = new OrderModel();
            $order_model->number = CountersModel::get_number('DD');
            $order_model->outside_target_id = $order['rid'];
            $order_model->type = 3;   //下载订单
            $order_model->store_id = $storeId;
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
            //是否开普勒订单
            if(key_exists('is_vop',$order)){
                $order_model->is_vop = $order['is_vop'];
            }else{
                $order_model->is_vop = '';
            }
            //开普勒订单号
            if(key_exists('jd_order_id',$order)){
                $order_model->jd_order_id = $order['jd_order_id']?$order['jd_order_id']:'';
            }else{
                $order_model->jd_order_id = '';
            }

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
                if(array_key_exists('storage_id',$item)){
                    $order_sku_model->out_storage_id = $item['storage_id'];
                }
                if(array_key_exists('vop_id',$item)){
                    $order_sku_model->vop_id = $item['vop_id'];
                }

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

                //判断可卖库存是否足够此订单
                $productSkuModel = new ProductsSkuModel();
                $quantity = $productSkuModel->sellCount($skuModel->id);
                if($item['quantity'] > $quantity){
                    DB::rollBack();
                    $message->addMessage(2, 'erp系统：【' . $item['name'] . $item['sku_name'] . '】 库存不足');
                    continue 2;
                }

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

            // 创建订单收款单
            $model = new ReceiveOrderModel();
            if (!$model->orderCreateReceiveOrder($order_id)) {
                DB::rollBack();
                Log::error('ID:'. $order_id .'订单发货创建订单收款单错误');
                return false;
            }

            DB::commit();

            //同步库存任务队列
            $this->dispatch(new ChangeSkuCount($order_model));
        }

    }*/


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

    /**
     * 订单状态Status访问修改器
     * 类型：1.普通订单；2.渠道订单；3.下载订单；4.导入订单；5.众筹订单
     *
     * @return string
     */
    public function getTypeValAttribute()
    {
        switch ($this->type) {
            case 1:
                $type = '普通订单';
                break;
            case 2:
                $type = '渠道订单';
                break;
            case 3:
                $type = '下载订单';
                break;
            case 4:
                $type = '导入订单';
                break;
            case 5:
                $type = '众筹订单';
                break;
            default:
                $type = '';
        }

        return $type;
    }

//    //更新未处理订单的状态
//    public function autoChangeStatus()
//    {
//        $orderList = OrderModel::where(['type' => 3,'status' =>5 ])->orWhere(['type' => 3,'status' =>10 ])->get();
//        foreach ($orderList as $order){
//            $platform = $order->store->platform;
//
//            switch ($platform){
//                case 1:
//                    //淘宝平台
//                    break;
//                case 2:
//                    $this->changeJdOrderStatus($order->id);
//                    break;
//                case 3:
//                    $this->changeShopOrderStatus($order->id);
//                    break;
//            }
//        }
//    }
//
//    //更新京东未处理订单的状态
//    protected function changeJdOrderStatus($order_id)
//    {
//        $api = new JdApi();
//        $resp = $api->pullOrderStatus($order_id);
//
//        if($resp->code != 0){
//            return false;
//        }
//        if(!$status = $resp->order->orderInfo->order_state){
//            return false;
//        }
//
//        switch ($status){
//            case 'WAIT_GOODS_RECEIVE_CONFIRM':
//                $status = 10;  //已发货
//                break;
//            case 'FINISHED_L':
//                $status = 20;  //完成
//                break;
//            case 'TRADE_CANCELED':
//                $status = 0;  //取消
//                break;
//            default:
//                return false;
//        }
//        $this->changeStatus($order_id, $status);
//
//        //创建出库单
//        if($status == 10 || $status == 20){
//            $out_warehouse = new OutWarehousesModel();
//            if (!$out_warehouse->orderCreateOutWarehouse($order_id)) {
//                Log::error('ID:'. $order_id .'订单发货,创建出库单错误');
//                return false;
//            }
//        }
//    }
//
//    //更新自营平台未处理订单状态
//    protected function changeShopOrderStatus($order_id)
//    {
//        $orderModel = OrderModel::find($order_id);
//        if(!$orderModel){
//            return false;
//        }
//        $shopApi = new ShopApi();
//        $result = $shopApi->getOrderInfo($orderModel->outside_target_id);
//        if($result['success'] == false){
//            return false;
//        }
//
//        $status = $result['data']['status'];
//        //自营商城订单状态: 0. 已取消;1.待付款；10.待发货(可以申请退款)；12.退款中；13.退款成功；15.待收货；16.待评价；20.订单完成；
//        //erp 状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
//        switch ($status){
//            case 0:
//                $status = 0;
//                break;
//            case 1:
//                $status = 1;
//                break;
//            case 10:
//                $status = 5;
//                break;
//            case 12:
//                $status = 5;
//                break;
//            case 13:
//                $status = 5;
//                break;
//            case 15:
//                $status = 10;
//                break;
//            case 16:
//                $status = 20;
//                break;
//            case 20:
//                $status = 20;
//                break;
//        }
//        $this->changeStatus($order_id, $status);
//
//        //创建出库单
//        if($status == 10 || $status == 20 ){
//            $out_warehouse = new OutWarehousesModel();
//            if (!$out_warehouse->orderCreateOutWarehouse($order_id)) {
//                Log::error('ID:'. $order_id .'订单发货,创建出库单错误');
//                return false;
//            }
//        }
//
//        //快递 同步
//        $express_code = isset($result['data']['express_caty'])?$result['data']['express_caty']:'';
//        if($express_code){
//           $logistics = LogisticsModel::where('zy_logistics_id',$express_code)->first();
//           if(!$logistics){
//               return true;
//           }
//           $orderModel->express_id = $logistics->id;
//           $orderModel->express_no = isset($result['data']['express_no'])?$result['data']['express_no']:'';
//           $orderModel->save();
//        }
//
//
//    }


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
     * 代发商品拆单
     * 判断订单中是否有代发商品，如果有代发商品则进行拆单
     *
     * @param OrderModel $order_model
     * @return bool
     */
    public function daifaSplit(OrderModel $order_model)
    {
        // 订单明细
        $order_sku = $order_model->orderSkuRelation;

        $count = $order_sku->count();
        if (1 >= $count) {
            return true;
        }

        // 拆单数据
        $data = [];
        $n = 0;
        $k = 1;

        // 判断商品明细中是否有代发商品，有则单独拆单
        foreach ($order_sku as $sku) {
            // 原订单不能为空
//            if ($n++ >= $count) {
//                break;
//            }
            $supplier = $sku->product->supplier;
            if (3 === (int)$supplier->type) {
                $supplier_id = $supplier->id;

                if (array_key_exists($supplier_id, $data)) {
                    $data[$supplier_id]['arr_id'][] = $sku->id;
                } else {
                    $data[$supplier_id] = [
                        'order_id' => $order_model->id,
                        'number' => $order_model->number . '-' . $k,
                        'arr_id' => [
                            $sku->id,
                        ],
                    ];
                }

                $k++;
                $n++;
            }
        }

        // 如果全部拆单 移除一组拆单数据，保留在原订单
        if ($n == $count) {
            array_pop($data);
        }

        if (empty($data)) {
            return true;
        } else {
            $result = $this->splitOrder($data);
            if ($result[0] == true) {
                return true;
            } else {
                Log::error($result);
                return false;
            }
        }
    }

    /**
     * 拆单
     *
     * @param $data
     * @return array
     */
    public function splitOrder($data)
    {
        // $data 数据结构示意
        /*[
            'order_id' => 1,
            'number' => '12345',
            'arr_id' => [
                1,
                2
            ],
        ];*/

//        $order_id = $data[0]['order_id'];

        foreach ($data as $v) {
            $order_id = $v['order_id'];
            break;
        }

        $order_info = OrderModel::find($order_id);
        if (!$order_info) {
            return [false, 'code error'];
        }
        //同步的订单可拆单
//        if($order_info->type !== 3){
//            return [false,'此单不能拆分'];
//        }

        try {

            DB::beginTransaction();

            //父订单要减去的金额
            $moneySum = 0;
            //父订单要减去的数量
            $productSum = 0;

            //创建新拆分的订单 修改原定订单明细的order_id 为新拆订单ID
            foreach ($data as $v) {

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
                $new_order->invoice_type = $order_info->invoice_type;
                $new_order->invoice_header = $order_info->invoice_header;
                $new_order->invoice_added_value_tax = $order_info->invoice_added_value_tax;
                $new_order->invoice_ordinary_number = $order_info->invoice_ordinary_number;

//            $order_model->seller_summary = $order_info['vender_remark'];
                $new_order->pec = $order_info->pec;
                $new_order->from_site = $order_info->from_site;
                $new_order->status = $order_info->status;
                $new_order->split_status = 1;
                $new_order->user_id_sales = $order_info->user_id_sales;

                $new_order->from_type = $order_info->from_type;
                $new_order->distributor_id = $order_info->distributor_id;

                if (!$new_order->save()) {
                    DB::rollBack();
                    Log::error(6);
                    return [false, 'new splitOrder save error'];
                }

                //新拆订单总金额
                $moneyCount = 0;
                //新拆订单总数量
                $productCount = 0;
                //将明细的order_id 改为新拆订单的ID
                foreach ($v['arr_id'] as $details_id) {
                    $details_info = OrderSkuRelationModel::find($details_id);
                    if (!$details_info) {
                        DB::rollBack();
                        Log::error(5);
                        return [false, 'details_id error'];
                    }
                    $moneyCount += $details_info->price * $details_info->quantity;
                    $productCount += $details_info->quantity;
                    $details_info->order_id = $new_order->id;
                    if (!$details_info->save()) {
                        DB::rollBack();
                        Log::error(4);
                        return [false, 'save new splitOrder error'];
                    }
                }

                $moneySum += $moneyCount;
                $productSum += $productCount;

                $new_order->total_money = $moneyCount;
                $new_order->pay_money = $moneyCount;
                $new_order->count = $productCount;
                if (!$new_order->save()) {
                    DB::rollBack();
                    Log::error(3);
                    return [false, 'save old order error'];
                }
            }

            //修改原订单信息
            $order_info->total_money = $order_info->total_money - $moneySum;
            $order_info->pay_money = $order_info->pay_money - $moneySum;
            $order_info->count = ($order_info->count - $productSum > 0) ? ($order_info->count - $productSum) : 0;
            $order_info->split_status = 1;
            if (!$order_info->save()) {
                DB::rollBack();
                Log::error(2);
                return [false, 'edit order error'];
            }

            //如果是自营平台订单拆单，同步至自营平台
            if ($order_info->store->platform == 3) {
                $array = [];
                $order_data = OrderModel::with('orderSkuRelation')->where('outside_target_id', $order_info->outside_target_id)->get();
                //拼接拆单参数
                foreach ($order_data as $v) {
                    $items = [];
                    foreach ($v->orderSkuRelation as $k) {
                        $items[] = $k->sku_number;
                    }

                    $array[] = ['id' => $v->number, 'items' => $items];
                }
                $shopApi = new ShopApi();
                $result = $shopApi->postSplitOrderInfo($order_info->outside_target_id, json_encode($array));
                if ($result['success'] == false) {
                    DB::rollBack();
                    Log::error($result['message']);
                    return [false, $result['message']];
                }
            }

            DB::commit();
            return [true, 'ok'];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return [false, 'exception error'];
        }

    }

    /**
     * 修改订单已付金额
     */
    public function changeReceivedMoney($received_money)
    {
        $this->received_money = $received_money;
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    /**
     * 完全删除订单及明细
     */
    public function deleteOrder()
    {
        $orderSkuRelation = $this->orderSkuRelation;
        if (!$orderSkuRelation->isEmpty()) {
            foreach ($orderSkuRelation as $j) {
                $j->forceDelete();
            }
        }
        $this->forceDelete();

        return true;
    }

    /**
     * 导入订单
     *
     * @param $data
     * @return array
     */
    static public function inOrder($data)
    {
        /*"日期" => "20170101"
        "sku" => "12345678,4344545"
        "商品" => "飞机,大炮"
        "数量" => "1,2"
        "单价" => "120,30"
        "销售金额" => 180.0
        "收货人" => "张三"
        "电话" => 15678234532.0
        "省" => "北京"
        "市" => "北京"
        "县" => "朝阳"
        "地址" => "北京朝阳 酒仙桥"
        "快递代码" => "SF"
        "快递单号" => 12345667.0
        "店铺太火鸟1米家2d3in渠道3d3in店4fiu5" => 1.0
        "仓库净土1_金华2751店3虚拟仓库4" => 4.0*/
        $new_data = [];
        foreach ($data as $v) {
            $new_data[] = $v;
        }
        $data = $new_data;

        //检测excel数据
        $count = count($data);
        for ($i = 0; $i < $count - 1; $i++) {
            if (empty($data[$i])) {
                return [false, '表格不能为空'];
            }
        }

        //检测是否重复导入
        $isset_order = OrderModel
            ::where(['order_start_time' => date("Y-m-d H:i:s", strtotime($data[0])), 'express_no' => $data[13]])
            ->count();
        if ($isset_order) {
            return [false, '订单导入重复'];
        }


        $order_model = new OrderModel();
        /**
         * 获取对应店铺
         */
        //店铺数组
        $store_arr = [1 => '太火鸟', 2 => '米家', 3 => 'D3IN 渠道', 4 => 'D3IN 751店', 5 => 'Fiu App'];
        $store_v = intval($data[14]);
        if (!isset($store_arr[$store_v])) {
            return [false, '店铺参数错误'];
        }

        //正式
        $storeMode = StorageModel::where(['name', '=', $store_arr[$store_v]])->first();
        //测试
//        $storeMode = StorageModel::first();

        if (!$storeMode) {
            return [false, '店铺不存在'];
        }
        $order_model->store_id = $storeMode->id;

        /**
         * 获取对应仓库
         */
        //仓库数组
        $storage_arr = [1 => '净土仓库（北京）', 2 => '金华仓库（浙江）', 3 => '751店仓（北京）', 4 => '虚拟仓库（代发）'];
        $storage_v = intval($data[15]);
        if (!isset($storage_arr[$storage_v])) {
            return [false, '仓库参数错误'];
        }

        //正式
        $storageModel = StorageModel::where('name', '=', $storage_arr[$storage_v])->first();
        //测试
//        $storageModel = StorageModel::first();

        if (!$storageModel) {
            return [false, '仓库不存在'];
        }
        $order_model->storage_id = $storageModel->id;

        /**
         * 获取物流
         */
        $express_arr = ['YTO', 'STO', 'SF', 'HHTT', 'ZTO', 'EMS', 'YD', 'UC', 'QFKD', 'ZJS', 'BTWL', 'GTO', 'DBL', 'FAST'];
        if (!in_array($data[12], $express_arr)) {
            return [false, '物流参数错误'];
        }

        //正式
        $logisticsModel = LogisticsModel::where('kdn_logistics_id', '=', $data[12])->first();
        //测试
//        $logisticsModel = LogisticsModel::first();

        if (!$logisticsModel) {
            return [false, '物流参数错误'];
        }
        $order_model->express_id = $logisticsModel->id;

        //参数转数组
        $sku_arr = explode(',', $data[1]);
        $product_name = explode(',', $data[2]);
        $product_count = explode(',', $data[3]);
        $price_arr = explode(',', $data[4]);

        $order_model->express_no = $data[13];
        $order_model->order_send_time = date("Y-m-d H:i:s", strtotime($data[0]));
        $order_model->number = CountersModel::get_number('DD');
        $order_model->outside_target_id = '';
        $order_model->type = 4;   //导入订单
        $order_model->payment_type = 1;
        $order_model->pay_money = $data[5];
        $order_model->total_money = $data[5];
        $order_model->freight = 0;
        $order_model->discount_money = 0;
        $order_model->buyer_name = $data[6];
        $order_model->buyer_tel = '';
        $order_model->buyer_phone = $data[7];
        $order_model->buyer_address = $data[11];
        $order_model->buyer_province = $data[8];
        $order_model->buyer_city = $data[9];
        $order_model->buyer_county = $data[10];
        $order_model->buyer_summary = '';
        $order_model->order_start_time = date("Y-m-d H:i:s", strtotime($data[0]));
        $order_model->invoice_info = '';
        $order_model->status = 10;
        $order_model->count = array_sum($product_count);
        if (!$order_model->save()) {
            return [false, '保存错误'];
        }
        $order_id = $order_model->id;

        //遍历保存订单商品明细
        $sku_count = count($sku_arr);
        for ($i = 0; $i < $sku_count; $i++) {
            $productSkuModel = ProductsSkuModel::where('number', '=', $sku_arr[$i])->first();
            if (!$productSkuModel) {
                return [false, 'sku编号不正确'];
            }
            if ($productSkuModel->quantity < $product_count[$i]) {
                return [false, '【' . $product_name[$i] . '】库存不足'];
            }
            $order_sku_model = new OrderSkuRelationModel();
            $order_sku_model->order_id = $order_id;
            $order_sku_model->sku_number = $sku_arr[$i];
            $order_sku_model->sku_name = $product_name[$i];
            $order_sku_model->quantity = $product_count[$i];
            $order_sku_model->price = $price_arr[$i];
            $order_sku_model->discount = '';
            $order_sku_model->sku_id = $productSkuModel->id;
            $order_sku_model->product_id = $productSkuModel->product->id;

            //增加付款占货量
            $skuModel = new ProductsSkuModel();
            if (!$skuModel->increasePayCount($productSkuModel->id, $product_count[$i])) {
                return [false, '自营平台同步订单时增加付款占货出错'];
            };

            if (!$order_sku_model->save()) {
                return [false, '订单明细保存失败'];
            }
        }

        // 创建订单收款单
        $model = new ReceiveOrderModel();
        if (!$model->orderCreateReceiveOrder($order_id)) {
            return [false, 'ID:' . $order_id . '订单发货创建订单收款单错误'];
        }

        //创建出库单
        $out_warehouse = new OutWarehousesModel();
        if (!$out_warehouse->orderCreateOutWarehouse($order_id)) {
            return [false, '订单创建出库单错误'];
        }

        return [true, 'ok'];
    }


    public static function boot()
    {
        parent::boot();
        self::created(function ($obj) {
            RecordsModel::addRecord($obj, 1, 12);

        });

        self::deleted(function ($obj) {
            RecordsModel::addRecord($obj, 3, 12);
        });

        self::updated(function ($obj) {
            $remark = $obj->getDirty();
            if (array_key_exists('status', $remark)) {
                $status = $remark['status'];
                switch ($status) {
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
            } else {
                RecordsModel::addRecord($obj, 2, 12, $remark);
            }

        });
    }

    //type = 2销售订单详情  type = 3 电商销售详情
    static public function salesOrder($salesOrder)
    {

        $orderSkuRelations = $salesOrder->orderSkuRelation;
        foreach ($orderSkuRelations as $orderSkuRelation) {
            $sku_id = $orderSkuRelation->sku_id;
            $sku = ProductsSkuModel::where('id', $sku_id)->first();
            if (!$sku) {
                return [false, '没有商品规格'];
            }
            //规格型号
            $salesOrder->mode = $sku->mode;
            //单位
            $salesOrder->weight = $sku->weight;
            //单价
            $salesOrder->unit_price = $orderSkuRelation->price;
            //数量
            $salesOrder->quantity = $orderSkuRelation->quantity;
            $product_id = $sku->product_id;
            $product = ProductsModel::where('id', $product_id)->first();
            if (!$product) {
                return [false, '没有商品名称'];
            }
            $supplier_id = $product->supplier;
            $supplier = SupplierModel::where('id', $supplier_id)->first();
            if (!$supplier) {
                return [false, '没有供应商'];
            }
            //供应商名称
            $salesOrder->supplier_name = $supplier->name;
            //供应商编号
            $salesOrder->sup_random_id = $supplier->random_id;
            //商品名称
            $salesOrder->product_name = $product->title;
        }
        return $salesOrder;
    }

    //订单列表
    static public function OrderLists($salesOrder)
    {
        $orderSkuRelations = $salesOrder->orderSkuRelation;
        foreach ($orderSkuRelations as $orderSkuRelation) {
            $sku_id = $orderSkuRelation->sku_id;
            $sku = ProductsSkuModel::where('id', $sku_id)->first();
            if (!$sku) {
                return [false, '没有商品规格'];
            }
            //规格型号
            $salesOrder->mode = $sku->mode;
            //单位
            $salesOrder->weight = $sku->weight;
            //单价
            $salesOrder->unit_price = $orderSkuRelation->price;
            //数量
            $salesOrder->quantity = $orderSkuRelation->quantity;
            $product_id = $sku->product_id;
            $product = ProductsModel::where('id', $product_id)->first();

            if (!$product) {
                return [false, '没有商品名称'];
            }
            $supplier_id = $product->supplier_id;
            $supplier = SupplierModel::where('id', $supplier_id)->first();
            if (!$supplier) {
                return [false, '没有供应商'];
            }
            //供应商名称
            $salesOrder->supplier_name = $supplier->name;
            //供应商编号
            $salesOrder->sup_random_id = $supplier->random_id;
            //商品名称
//            $salesOrder->product_name = $product->title;
//            $salesOrder->product_name = $orderSkuRelation->sku_name;
            $product_name[] = $orderSkuRelation->sku_name;
        }
        return $salesOrder;
    }

    /**
     *
     * 应用来源：1.商城；2. Fiu
     *
     * @return string
     */
    public function getFormAppValAttribute()
    {
        switch ($this->form_app) {
            case 0:
                $form_app = '';
                break;
            case 1:
                $form_app = '商城';
                break;
            case 2:
                $form_app = 'Fiu';
                break;
            default:
                $form_app = '';
        }

        return $form_app;
    }


    /**
     * 众筹导入
     */
    static public function zcInOrder($data, $store_id, $product_id, $product_sku_id, $user_id)
    {
        /*1订单详细
        *0项目编号 => '81465',
        1项目名称 => '奶爸必备秒冲40℃恒温奶瓶',
        2订单号   => '15548244275049',
        3支付时间 => '2017-06-01 10:17:55',
        *4回报内容 => '感谢您对奶爸爸多功能奶瓶的支持！众筹结束后，您将以低于预期市场价获得奶爸爸奶粉盒一个。',
        5产品规格 => NULL,
        6档位金额 => '30.00',
        7支持数量 => '1',
        8备注 => NULL,
        9客服备注 => NULL,
         */
        /*2联系人
        认购单ID0 => '30358618',
          订单号1 => '14568806716688',
          回报类型2 => '实物回报',
          档位价格3 => '19999.0000',
          支持金额4 => '19999.0000',
          回报内容5 => '感谢您的支持！不插电的RO净水机，引爆美国厨房净水革命。众筹结束后，您将以 19999 元的价格获得预计市场价格为 2999 元的 “四季沐歌 WOW 净水机”10 台。',
          产品规格6 => '无',
          支持数量7 => '1',
          收货人姓名8 => '刘慧',
          电话9 => '13621363406',
          省10 => '北京',
          市11 => '朝阳区',
          区12 => '四环到五环之间',
          城镇13 => NULL,
          地址14 => '驼房营南里甲8号305室',
          EMAIL15 => NULL,
          快递公司16 => '顺丰快递',
          运单号/电子码17 => '152325594234',
          发票信息18 => '无',
          备注信息19 => 'LH',
          客服备注20 => NULL,
          商家备注21 => NULL,
     */
        $new_data = [];
        foreach ($data as $v) {
            $new_data[] = $v;

        }
        $data = $new_data;

        $count = count($data);
        //检测第二个文件
        $isset_order = OrderModel
            ::where(['number' => $data[1]])
            ->count();
        if ($isset_order) {
            return [false, '订单导入重复'];
        }
        $order = new OrderModel();
        $order->number = $data[1];
        $order->type = 5;
        $order->status = 8;
        $order->outside_target_id = '';
        $order->payment_type = 1;
        $order->store_id = $store_id;

        $order->pay_money = $data[3];
        $order->total_money = $data[4];
        $order->count = $data[7];
        $order->buyer_name = $data[8];
        $order->buyer_phone = $data[9];
        $order->buyer_province = $data[10];
        $order->buyer_city = $data[11];
        $order->buyer_county = $data[12];
        $order->buyer_township = $data[13] ? $data[13] : '';
        $order->buyer_address = $data[14];

        $logistics = LogisticsModel::where('area', $data[16])->first();
        $order->express_id = $logistics['id'];
        $order->express_no = $data[17];
        $order->invoice_info = $data[18] ? $data[18] : '';
        $order->summary = $data[19] ? $data[19] : '';
        $order->seller_summary = $data[21] ? $data[21] : '';
        $order->user_id = $user_id;
        $order->user_id_sales = config('constant.user_id_sales');
        if ($order->save()) {
            //保存收款单
            $receiveOrder = new ReceiveOrderModel();
            $receiveOrder->amount = $order->pay_money;
            $receiveOrder->payment_user = $order->buyer_name;
            $receiveOrder->type = 5;
            $receiveOrder->status = 1;
            $receiveOrder->target_id = $order->id;
            $receiveOrder->user_id = Auth::user() ? Auth::user()->id : 0;
            $number = CountersModel::get_number('SK');
            $receiveOrder->number = $number;
            $receiveOrder->save();

            //保存订单明细
            $order_sku = new OrderSkuRelationModel();
            $order_sku->order_id = $order->id;
            $product_sku = ProductsSkuModel::where('id', $product_sku_id)->first();
            $order_sku->sku_number = $product_sku->number;
            $order_sku->sku_id = $product_sku_id;
            $product = ProductsModel::where('id', $product_id)->first();
            $order_sku->product_id = $product_id;
            $order_sku->sku_name = $product->title . '--' . $product_sku->mode;
            $order_sku->quantity = $data[7];
            $order_sku->price = $data[3];
            $order_sku->save();
            return [true, 'ok'];
        } else {
            return [false, '保存错误'];
        }

        return [true, 'ok'];

    }

    /**
     * 太火鸟自营导入
     */
    static public function zyInOrder($data, $user_id, $mime, $file_records_id)
    {

        $name = uniqid();
        $file = config('app.tmp_path') . $name . '.' . $mime;
        $current = file_get_contents($data, true);

        $files = file_put_contents($file, $current);
        $results = Excel::load($file, function ($reader) {
        })->get();
        $results = $results->toArray();
        //订单总条数
        $total_count = count($results);
        //成功的订单号
        $success_outside_target_id = [];
        //重复的订单号
        $repeat_outside_target_id = [];
        //不存在的sku
        $no_sku_number = [];
        //空字段的订单号
        $null_field = [];
        //商品库存不够的单号
        $sku_quantity = [];
        //商品未开放的
        $product_unopened = [];

        foreach ($results as $d) {
            $new_data = [];
            foreach ($d as $v) {
                $new_data[] = $v;
            }

            $data = $new_data;
            //检测excel数据是否为空
            $count = count($data);
            for ($i = 0; $i < $count - 1; $i++) {
                if (empty($data[$i])) {
                    continue;
                }
            }

            $sku_number = $data[2];

            $skuDistributor = SkuDistributorModel::where('distributor_number', $sku_number)->where('distributor_id', $user_id)->first();

            if ($skuDistributor) {
                $sku = ProductsSkuModel::where('number', $skuDistributor->sku_number)->first();
                $not_see_product_id_arr = UserProductModel::notSeeProductId($user_id);

                $product_id = $sku->product_id;
                $products = ProductsModel::where('id', $product_id)->where('saas_type', 1)->whereNotIn('id', $not_see_product_id_arr)->get();

            } else {
                $sku = ProductsSkuModel::where('number', $sku_number)->first();
                $not_see_product_id_arr = UserProductModel::notSeeProductId($user_id);

                $product_id = $sku->product_id;
                $products = ProductsModel::where('id', $product_id)->where('saas_type', 1)->whereNotIn('id', $not_see_product_id_arr)->get();

            }
            if ($products->isEmpty()) {
                $product_unopened = $data[14];
                continue;

            }
            //如果没有sku号码，存入到数组中
            if (!$sku) {
                $no_sku_number[] = $data[14];
                continue;
            }
            //增加 付款订单占货
            $productSku = new ProductsSkuModel();
            $productSku->increasePayCount($sku->id, $data[3]);

            $outside_target_id = $data[14];
            $outside_target = OrderModel::where('outside_target_id', $outside_target_id)->where('user_id', $user_id)->first();
            //如果订单号重复了，存入到数组中
            if ($outside_target) {
                $repeat_outside_target_id[] = $data[14];
                continue;
            }
            $product_sku_id = $sku->id;
            $order = new OrderModel();
            $order->number = CountersModel::get_number('DD');
            $order->status = 5;
            $order->outside_target_id = $outside_target_id;
            $order->payment_type = 1;
            $order->type = 6;
            $order->order_start_time = $data[0];

            $order->payment_type = 1;
            $order->freight = 0;
            $order->discount_money = 0;
            $order->buyer_name = $data[4];
            $order->buyer_tel = '';
            $order->buyer_phone = $data[5];
            $order->buyer_address = $data[9];
            $order->buyer_province = $data[6];
            $order->buyer_city = $data[7];
            $order->buyer_county = $data[8];
            $order->user_id = $user_id;
            $order->count = $data[3];
            $order->buyer_summary = $data[11];
            $order->seller_summary = $data[12];
            $order->buyer_zip = $data[13];
            $order->excel_type = 1;
            $order->user_id_sales = config('constant.user_id_sales');
            $order->store_id = config('constant.store_id');
            //设置仓库id
            $storeStorageLogistics = StoreStorageLogisticModel::where('store_id', config('constant.store_id'))->first();
            if ($storeStorageLogistics) {
                $order->storage_id = $storeStorageLogistics->storage_id;
                $order->express_id = $storeStorageLogistics->logistics_id;
            }
            $order->from_type = 2;
            //姓名，电话，地址有一项没有填写的记录到数组中
            if (empty($data[4]) || empty($data[5]) || empty($data[9])) {
                $null_field[] = $data[14];
                continue;
            }
            //检查sku库存是否够用
            $product_sku_relation = new ProductSkuRelation();
            $product_sku = $product_sku_relation->skuInfo($user_id, $product_sku_id);
            $product_sku_quantity = $product_sku_relation->reduceSkuQuantity($product_sku_id, $user_id, $data[3]);
            $order->total_money = $data[3] * $product_sku['price'];
            $order->pay_money = $data[3] * $product_sku['price'];
            if ($product_sku_quantity[0] === false) {
                $sku_quantity[] = $data[14];
                continue;
            }

            if ($order->save()) {
                //保存收款单
                $receiveOrder = new ReceiveOrderModel();
                $receiveOrder->amount = $order->pay_money;
                $receiveOrder->payment_user = $order->buyer_name;
                $receiveOrder->type = 6;
                $receiveOrder->status = 1;
                $receiveOrder->target_id = $order->id;
                $receiveOrder->user_id = Auth::user() ? Auth::user()->id : 0;
                $number = CountersModel::get_number('SK');
                $receiveOrder->number = $number;
                $receiveOrder->save();

                //保存订单明细
                $order_sku = new OrderSkuRelationModel();
                $order_sku->order_id = $order->id;
                $order_sku->sku_number = $product_sku['number'];
                $order_sku->sku_id = $product_sku_id;
                $product = ProductsModel::where('id', $product_id)->first();
                $order_sku->product_id = $product_id;
                $order_sku->sku_name = $product->title . '--' . $product_sku['mode'];
                $order_sku->quantity = $data[24];
                $order_sku->price = $product_sku['price'];
                if (!$order_sku->save()) {
                    echo '订单详情保存失败';
                }
            } else {
                echo '订单保存失败';
            }
            //成功导入的订单号
            $success_outside_target_id[] = $data[14];
        }
        //导入成功的站外订单号
        $success_outside = $success_outside_target_id;
        //成功导入的订单数
        $success_count = count($success_outside);

        //不存在sku编码的
        $no_sku = $no_sku_number;
        $no_sku_string = implode(',', $no_sku);
        //没有找到sku的订单数
        $no_sku_count = count($no_sku);

        //重复的订单号
        $repeat_outside = $repeat_outside_target_id;
        $repeat_outside_string = implode(',', $repeat_outside);
        //重复导入的订单数
        $repeat_outside_count = count($repeat_outside);

        //空字段的订单号
        $nullField = $null_field;
        $null_field_string = implode(',', $nullField);
        //空字段的数量
        $null_field_count = count($nullField);

        //sku库存不够的
        $sku_storage_quantity = $sku_quantity;
        $sku_storage_quantity_string = implode(',', $sku_storage_quantity);
        $sku_storage_quantity_count = count($sku_storage_quantity);

        //商品未开放的
        $product_status = $product_unopened;
        $product_unopened_string = implode(',', $product_status);
        $product_unopened_count = count($product_status);

        $fileRecord = FileRecordsModel::where('id', $file_records_id)->first();
        $file_record['status'] = 1;
        $file_record['total_count'] = $total_count ? $total_count : 0;
        $file_record['success_count'] = $success_count ? $success_count : 0;
        $file_record['no_sku_count'] = $no_sku_count ? $no_sku_count : 0;
        $file_record['no_sku_string'] = $no_sku_string ? $no_sku_string : '';
        $file_record['repeat_outside_count'] = $repeat_outside_count ? $repeat_outside_count : 0;
        $file_record['repeat_outside_string'] = $repeat_outside_string ? $repeat_outside_string : '';
        $file_record['null_field_count'] = $null_field_count ? $null_field_count : 0;
        $file_record['null_field_string'] = $null_field_string ? $null_field_string : '';
        $file_record['sku_storage_quantity_count'] = $sku_storage_quantity_count ? $sku_storage_quantity_count : 0;
        $file_record['sku_storage_quantity_string'] = $sku_storage_quantity_string ? $sku_storage_quantity_string : '';
        $file_record['product_unopened_count'] = $product_unopened_count ? $product_unopened_count : 0;
        $file_record['product_unopened_string'] = $product_unopened_string ? $product_unopened_string : '';
        $fileRecord->update($file_record);

        if ($fileRecord->success_count == 0 && $fileRecord->repeat_outside_count == 0 && $fileRecord->null_field_count == 0 && $fileRecord->sku_storage_quantity_count == 0) {
            $all_file['status'] = 2;
            $fileRecord->update($all_file);
        }

        unlink($file);
        return;
        /**
         * "日期" => 20170821.0
         * "商品名称" => "奶爸爸"
         * "店铺太火鸟1米家2d3in渠道3d3in店4fiu5" => 1.0
         * "sku" => 117081745529.0
         * "数量" => 3.0
         * "收货人" => "蔡先生"
         * "电话" => 18132382134.0
         * "省" => "北京"
         * "市" => "北京"
         * "县" => "朝阳"
         * "地址" => "酒仙桥751艺术区"
         */

    }

    /**
     * 京东订单导入
     */
    static public function jdInOrder($data, $user_id, $mime, $file_records_id)
    {

        /**
         * "订单号" => 1234567.0
         * "商品id" => 117081772670.0
         * "商品名称" => "傻蛋"
         * "订单数量" => 3.0
         * "支付方式" => 1.0
         * "下单时间" => 20170823.0
         * "京东价" => 119
         * "订单金额" => 357
         * "结算金额" => 357
         * "余额支付" => null
         * "应付金额" => 357
         * "订单状态" => 5.0
         * "订单类型" => 6.0
         * "下单账号" => null
         * "客户姓名" => "隔壁老王"
         * "客户地址" => "隔壁老王家"
         * "联系电话" => 110119120.0
         * "订单备注" => "买家备注"
         * "发票类型" => null
         * "发票抬头" => null
         * "发票内容" => null
         * "商家备注" => "卖家备注"
         * "商家备注等级等级1_5为由高到低" => null
         * "运费金额" => null
         * "付款确认时间" => null
         * "增值税发票" => null
         * "货号" => null
         * "订单完成时间" => 20170826.0
         * "订单来源" => null
         * "订单渠道" => null
         * "送装服务" => null
         * "服务费" => null
         * "仓库id" => 1.0
         * "仓库名称" => "北京"
         * "普通发票纳税编号" => null
         */
        $name = uniqid();
        $file = config('app.tmp_path') . $name . '.' . $mime;
        $current = file_get_contents($data, true);

        $files = file_put_contents($file, $current);
        $results = Excel::load($file, function ($reader) {
        })->get();
        $results = $results->toArray();
        //订单总条数
        $total_count = count($results);
        //成功的订单号
        $success_outside_target_id = [];
        //重复的订单号
        $repeat_outside_target_id = [];
        //不存在的sku
        $no_sku_number = [];
        //空字段的订单号
        $null_field = [];
        //商品库存不够的单号
        $sku_quantity = [];
        //商品未开放的
        $product_unopened = [];
        foreach ($results as $d) {
            $new_data = [];
            foreach ($d as $v) {
                $new_data[] = $v;
            }

            $data = $new_data;
            $sku_number = $data[1];
//            $sku = ProductsSkuModel::where('number', $sku_number)->first();
            $skuDistributor = SkuDistributorModel::where('distributor_number', $sku_number)->where('distributor_id', $user_id)->first();

            if ($skuDistributor) {
                $sku = ProductsSkuModel::where('number', $skuDistributor->sku_number)->first();
                $not_see_product_id_arr = UserProductModel::notSeeProductId($user_id);

                $product_id = $sku->product_id;
                $products = ProductsModel::where('id', $product_id)->where('saas_type', 1)->whereNotIn('id', $not_see_product_id_arr)->get();

            } else {
                $sku = ProductsSkuModel::where('number', $sku_number)->first();
                $not_see_product_id_arr = UserProductModel::notSeeProductId($user_id);

                $product_id = $sku->product_id;
                $products = ProductsModel::where('id', $product_id)->where('saas_type', 1)->whereNotIn('id', $not_see_product_id_arr)->get();

            }
            if ($products->isEmpty()) {
                $product_unopened = $data[0];
                continue;

            }
            //如果没有sku号码，存入到数组中
            if (!$sku) {
                $no_sku_number[] = 'jd' . $data[0];
                continue;
            }
            //增加 付款订单占货
            $productSku = new ProductsSkuModel();
            $productSku->increasePayCount($sku->id, $data[3]);

            $outside_target_id = 'jd' . $data[0];
            $outside_target = OrderModel::where('outside_target_id', $outside_target_id)->where('user_id', $user_id)->first();
            //订单重复导入
            if ($outside_target) {
                $repeat_outside_target_id[] = 'jd' . $data[0];
                continue;
            }
            $product_sku_id = $sku->id;

            $order = new OrderModel();
            $order->number = CountersModel::get_number('DD');
            $order->status = 5;
            $order->outside_target_id = $outside_target_id;
            $order->payment_type = 1;
            $order->type = (int)$data[12];
            $order->order_start_time = $data[5];
            $order->order_send_time = $data[27] ? $data[27] : '';

            $order->payment_type = 1;
            $order->freight = 0;
            $order->discount_money = 0;
            $order->buyer_name = $data[14];
            $order->buyer_tel = '';
            $order->buyer_phone = $data[16];
            $order->buyer_address = $data[15];
            $order->buyer_province = '';
            $order->buyer_city = '';
            $order->buyer_county = '';
            $order->user_id = $user_id;
            $order->count = $data[3];
            $order->buyer_summary = $data[17];
            $order->seller_summary = $data[21];
            $order->buyer_zip = '';
            $order->storage_id = $data[32];
            $order->excel_type = 2;
            $order->user_id_sales = config('constant.user_id_sales');
            $order->store_id = config('constant.store_id');
            //设置仓库id
            $storeStorageLogistics = StoreStorageLogisticModel::where('store_id', config('constant.store_id'))->first();
            if ($storeStorageLogistics) {
                $order->storage_id = $storeStorageLogistics->storage_id;
                $order->express_id = $storeStorageLogistics->logistics_id;
            }
            $order->from_type = 2;
            //姓名，电话，地址有一项没有填写的记录到数组中
            if (empty($data[14]) || empty($data[15]) || empty($data[16])) {
                $null_field[] = 'jd' . $data[0];
                continue;
            }
            //检查sku库存是否够用
            $product_sku_relation = new ProductSkuRelation();
            $product_sku = $product_sku_relation->skuInfo($user_id, $product_sku_id);
            $product_sku_quantity = $product_sku_relation->reduceSkuQuantity($product_sku_id, $user_id, $data[3]);
            $order->total_money = $data[3] * $product_sku['price'];
            $order->pay_money = $data[3] * $product_sku['price'];
            if ($product_sku_quantity[0] === false) {
                $sku_quantity[] = 'jd' . $data[0];
                continue;
            }
            if ($order->save()) {
                //保存收款单
                $receiveOrder = new ReceiveOrderModel();
                $receiveOrder->amount = $order->pay_money;
                $receiveOrder->payment_user = $order->buyer_name;
                $receiveOrder->type = 6;
                $receiveOrder->status = 1;
                $receiveOrder->target_id = $order->id;
                $receiveOrder->user_id = Auth::user() ? Auth::user()->id : 0;
                $number = CountersModel::get_number('SK');
                $receiveOrder->number = $number;
                $receiveOrder->save();

                //保存订单明细
                $order_sku = new OrderSkuRelationModel();
                $order_sku->order_id = $order->id;
                $order_sku->sku_number = $product_sku['number'];
                $order_sku->sku_id = $product_sku_id;
                $product = ProductsModel::where('id', $product_id)->first();
                $order_sku->product_id = $product_id;
                $order_sku->sku_name = $product->title . '--' . $product_sku['mode'];
                $order_sku->quantity = $data[24];
                $order_sku->price = $product_sku['price'];
                if (!$order_sku->save()) {
                    echo '订单详情保存失败';
                }
            } else {
                echo '订单保存失败';
            }
            //成功导入的订单号
            $success_outside_target_id[] = 'jd' . $data[0];
        }
        //导入成功的站外订单号
        $success_outside = $success_outside_target_id;
        //成功导入的订单数
        $success_count = count($success_outside);
        //不存在sku编码的
        $no_sku = $no_sku_number;
        $no_sku_string = implode(',', $no_sku);
        //没有找到sku的订单数
        $no_sku_count = count($no_sku);

        //重复的订单号
        $repeat_outside = $repeat_outside_target_id;
        $repeat_outside_string = implode(',', $repeat_outside);
        //重复导入的订单数
        $repeat_outside_count = count($repeat_outside);

        //空字段的订单号
        $nullField = $null_field;
        $null_field_string = implode(',', $nullField);
        //空字段的数量
        $null_field_count = count($nullField);

        //sku库存不够的
        $sku_storage_quantity = $sku_quantity;
        $sku_storage_quantity_string = implode(',', $sku_storage_quantity);
        $sku_storage_quantity_count = count($sku_storage_quantity);

        //商品未开放的
        $product_status = $product_unopened;
        $product_unopened_string = implode(',', $product_status);
        $product_unopened_count = count($product_status);

        $fileRecord = FileRecordsModel::where('id', $file_records_id)->first();
        $file_record['status'] = 1;
        $file_record['total_count'] = $total_count ? $total_count : 0;
        $file_record['success_count'] = $success_count ? $success_count : 0;
        $file_record['no_sku_count'] = $no_sku_count ? $no_sku_count : 0;
        $file_record['no_sku_string'] = $no_sku_string ? $no_sku_string : '';
        $file_record['repeat_outside_count'] = $repeat_outside_count ? $repeat_outside_count : 0;
        $file_record['repeat_outside_string'] = $repeat_outside_string ? $repeat_outside_string : '';
        $file_record['null_field_count'] = $null_field_count ? $null_field_count : 0;
        $file_record['null_field_string'] = $null_field_string ? $null_field_string : '';
        $file_record['sku_storage_quantity_count'] = $sku_storage_quantity_count ? $sku_storage_quantity_count : 0;
        $file_record['sku_storage_quantity_string'] = $sku_storage_quantity_string ? $sku_storage_quantity_string : '';
        $file_record['product_unopened_count'] = $product_unopened_count ? $product_unopened_count : 0;
        $file_record['product_unopened_string'] = $product_unopened_string ? $product_unopened_string : '';
        $fileRecord->update($file_record);

        if ($fileRecord->success_count == 0 && $fileRecord->repeat_outside_count == 0 && $fileRecord->null_field_count == 0 && $fileRecord->sku_storage_quantity_count == 0) {
            $all_file['status'] = 2;
            $fileRecord->update($all_file);
        }

        unlink($file);
        return;

    }

    /**
     * 淘宝订单导入
     */
    static public function tbInOrder($data, $user_id, $mime, $file_records_id)
    {
        /**
         * "订单编号" => 1234567.0
         * "买家会员名" => null
         * "买家支付宝账号" => null
         * "买家应付货款" => null
         * "买家应付邮费" => null
         * "买家支付积分" => null
         * "总金额" => 357.0
         * "返点积分" => null
         * "买家实际支付金额" => null
         * "买家实际支付积分" => null
         * "订单状态" => 5.0
         * "买家留言" => ""
         * "收货人姓名" => "张三"
         * "收获地址" => "张三他们家"
         * "运送方式" => null
         * "联系电话" => 69908888.0
         * "联系手机" => 18132221234.0
         * "订单创建时间" => 20170823.0
         * "订单付款时间" => null
         * "宝贝标题" => "傻蛋"
         * "宝贝种类" => null
         * "物流单号" => "快递单号"
         * "物流公司" => "快递公司"
         * "订单备注" => "买家备注"
         * "宝贝总数量" => 3.0
         * "店铺id" => 1.0
         * "店铺名称" => "太火鸟"
         * "订单关闭原因" => null
         * "卖家服务费" => null
         * "买家服务费" => null
         * "发票抬头" => null
         * "是否手机订单" => null
         * "分阶段订单信息" => null
         * "特权订金订单id" => null
         * "是否上传合同照片" => null
         * "是否上传小票" => null
         * "是否代付" => null
         * "订金排名" => null
         * "修改后的sku" => 117081172670.0
         * "修改后的收货地址" => "张三他大舅家"
         * "异常信息" => null
         * "天猫卡券抵扣" => null
         * "集分宝抵扣" => null
         * "是否是o2o交易" => null
         * "退款金额" => null
         * "预约门店" => null
         */
        $name = uniqid();
        $file = config('app.tmp_path') . $name . '.' . $mime;
        $current = file_get_contents($data, true);

        $files = file_put_contents($file, $current);
        $results = Excel::load($file, function ($reader) {
        })->get();
        $results = $results->toArray();
        //订单总条数
        $total_count = count($results);
        //成功的订单号
        $success_outside_target_id = [];
        //重复的订单号
        $repeat_outside_target_id = [];
        //不存在的sku
        $no_sku_number = [];
        //空字段的订单号
        $null_field = [];
        //商品库存不够的单号
        $sku_quantity = [];
        //商品未开放的
        $product_unopened = [];
        foreach ($results as $d) {
            $new_data = [];
            foreach ($d as $v) {
                $new_data[] = $v;
            }

            $data = $new_data;
            $sku_number = $data[38];
            $skuDistributor = SkuDistributorModel::where('distributor_number', $sku_number)->where('distributor_id', $user_id)->first();
            if ($skuDistributor) {
                $sku = ProductsSkuModel::where('number', $skuDistributor->sku_number)->first();
                $not_see_product_id_arr = UserProductModel::notSeeProductId($user_id);

                $product_id = $sku->product_id;
                $products = ProductsModel::where('id', $product_id)->where('saas_type', 1)->whereNotIn('id', $not_see_product_id_arr)->get();

            } else {
                $sku = ProductsSkuModel::where('number', $sku_number)->first();
                $not_see_product_id_arr = UserProductModel::notSeeProductId($user_id);

                $product_id = $sku->product_id;
                $products = ProductsModel::where('id', $product_id)->where('saas_type', 1)->whereNotIn('id', $not_see_product_id_arr)->get();

            }
            if ($products->isEmpty()) {
                $product_unopened = $data[0];
                continue;

            }
            //如果没有sku号码，存入到数组中
            if (!$sku) {
                $no_sku_number[] = 'tb' . $data[0];
                continue;
            }
            //增加 付款订单占货
            $productSku = new ProductsSkuModel();
            $productSku->increasePayCount($sku->id, $data[24]);
            $outside_target_id = 'tb' . $data[0];
            $outside_target = OrderModel::where('outside_target_id', $outside_target_id)->where('user_id', $user_id)->first();
            //订单重复导入
            if ($outside_target) {
                $repeat_outside_target_id[] = 'tb' . $data[0];
                continue;
            }
            $product_sku_id = $sku->id;

            $order = new OrderModel();
            $order->number = CountersModel::get_number('DD');
            $order->status = 5;
            $order->outside_target_id = $outside_target_id;
            $order->payment_type = 1;
            $order->type = 6;
            $order->order_start_time = $data[17];

            $order->payment_type = 1;
            $order->freight = 0;
            $order->discount_money = 0;
            $order->buyer_name = $data[12];
            $order->buyer_tel = $data[15];
            $order->buyer_phone = $data[16];
            $order->buyer_address = $data[13];
            $order->buyer_province = '';
            $order->buyer_city = '';
            $order->buyer_county = '';
            $order->user_id = $user_id;
            $order->count = $data[24];
            $order->buyer_summary = $data[23];
            $order->seller_summary = '';
            $order->buyer_zip = '';
            $order->total_money = $data[6];
            $order->pay_money = $data[6];

            $order->excel_type = 3;
            $order->user_id_sales = config('constant.user_id_sales');
            $order->store_id = config('constant.store_id');
            //设置仓库id
            $storeStorageLogistics = StoreStorageLogisticModel::where('store_id', config('constant.store_id'))->first();
            if ($storeStorageLogistics) {
                $order->storage_id = $storeStorageLogistics->storage_id;
                $order->express_id = $storeStorageLogistics->logistics_id;
            }
            $order->from_type = 2;

            //姓名，电话，地址有一项没有填写的记录到数组中
            if (empty($data[12]) || empty($data[13]) || empty($data[16])) {
                $null_field[] = 'tb' . $data[0];
                continue;
            }
            //检查sku库存是否够用
            $product_sku_relation = new ProductSkuRelation();
            $product_sku = $product_sku_relation->skuInfo($user_id, $product_sku_id);
            $product_sku_quantity = $product_sku_relation->reduceSkuQuantity($product_sku_id, $user_id, $data[3]);
            $order->total_money = $data[3] * $product_sku['price'];
            $order->pay_money = $data[3] * $product_sku['price'];
            if ($product_sku_quantity[0] === false) {
                $sku_quantity[] = 'tb' . $data[0];
                continue;
            }
            if ($order->save()) {
                //保存收款单
                $receiveOrder = new ReceiveOrderModel();
                $receiveOrder->amount = $order->pay_money;
                $receiveOrder->payment_user = $order->buyer_name;
                $receiveOrder->type = 6;
                $receiveOrder->status = 1;
                $receiveOrder->target_id = $order->id;
                $receiveOrder->user_id = Auth::user() ? Auth::user()->id : 0;
                $number = CountersModel::get_number('SK');
                $receiveOrder->number = $number;
                $receiveOrder->save();

                //保存订单明细
                $order_sku = new OrderSkuRelationModel();
                $order_sku->order_id = $order->id;
                $order_sku->sku_number = $product_sku['number'];
                $order_sku->sku_id = $product_sku_id;
                $product = ProductsModel::where('id', $product_id)->first();
                $order_sku->product_id = $product_id;
                $order_sku->sku_name = $product->title . '--' . $product_sku['mode'];
                $order_sku->quantity = $data[24];
                $order_sku->price = $product_sku['price'];
                if (!$order_sku->save()) {
                    echo '订单详情保存失败';
                }
            } else {
                echo '订单保存失败';
            }
            //成功导入的订单号
            $success_outside_target_id[] = 'tb' . $data[0];
        }
        //导入成功的站外订单号
        $success_outside = $success_outside_target_id;
        //成功导入的订单数
        $success_count = count($success_outside);
        //不存在sku编码的
        $no_sku = $no_sku_number;
        $no_sku_string = implode(',', $no_sku);
        //没有找到sku的订单数
        $no_sku_count = count($no_sku);

        //重复的订单号
        $repeat_outside = $repeat_outside_target_id;
        $repeat_outside_string = implode(',', $repeat_outside);
        //重复导入的订单数
        $repeat_outside_count = count($repeat_outside);

        //空字段的订单号
        $nullField = $null_field;
        $null_field_string = implode(',', $nullField);
        //空字段的数量
        $null_field_count = count($nullField);

        //sku库存不够的
        $sku_storage_quantity = $sku_quantity;
        $sku_storage_quantity_string = implode(',', $sku_storage_quantity);
        $sku_storage_quantity_count = count($sku_storage_quantity);

        //商品未开放的
        $product_status = $product_unopened;
        $product_unopened_string = implode(',', $product_status);
        $product_unopened_count = count($product_status);

        $fileRecord = FileRecordsModel::where('id', $file_records_id)->first();
        $file_record['status'] = 1;
        $file_record['total_count'] = $total_count ? $total_count : 0;
        $file_record['success_count'] = $success_count ? $success_count : 0;
        $file_record['no_sku_count'] = $no_sku_count ? $no_sku_count : 0;
        $file_record['no_sku_string'] = $no_sku_string ? $no_sku_string : '';
        $file_record['repeat_outside_count'] = $repeat_outside_count ? $repeat_outside_count : 0;
        $file_record['repeat_outside_string'] = $repeat_outside_string ? $repeat_outside_string : '';
        $file_record['null_field_count'] = $null_field_count ? $null_field_count : 0;
        $file_record['null_field_string'] = $null_field_string ? $null_field_string : '';
        $file_record['sku_storage_quantity_count'] = $sku_storage_quantity_count ? $sku_storage_quantity_count : 0;
        $file_record['sku_storage_quantity_string'] = $sku_storage_quantity_string ? $sku_storage_quantity_string : '';
        $file_record['product_unopened_count'] = $product_unopened_count ? $product_unopened_count : 0;
        $file_record['product_unopened_string'] = $product_unopened_string ? $product_unopened_string : '';
        $fileRecord->update($file_record);
        if ($fileRecord->success_count == 0 && $fileRecord->repeat_outside_count == 0 && $fileRecord->null_field_count == 0 && $fileRecord->sku_storage_quantity_count == 0) {
            $all_file['status'] = 2;
            $fileRecord->update($all_file);
        }
        unlink($file);
        return;

    }

    /**
     * 获取导出代发供应商的订单query
     *
     * @param $supplier_id
     * @param $start_date
     * @param $end_date
     * @return mixed
     */
    public static function supplierOrderQuery($supplier_id, $start_date, $end_date)
    {
        if ($start_date && $end_date) {
            $start_date = date("Y-m-d H:i:s", strtotime($start_date));
            $end_date = date("Y-m-d H:i:s", strtotime($end_date));
        }

        $query = DB::table('order_sku_relation')
            ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->join('products_sku', 'order_sku_relation.sku_id', '=', 'products_sku.id')
            ->join('logistics', 'order.express_id', '=', 'logistics.id')
            ->whereBetween('order_sku_relation.created_at', [$start_date, $end_date])
            ->where('products.supplier_id', '=', $supplier_id)
            ->where('order.status', '=', '8');

        return $query;
    }

    public static function supplierOrderList($supplier_id, $start_date, $end_date, $per_page = 15)
    {
        return self::supplierOrderQuery($supplier_id, $start_date, $end_date)
            ->select('order.*')->paginate($per_page);
    }

    /**
     * 获取导出分销的订单query
     *
     * @param $supplier_id
     * @param $start_date
     * @param $end_date
     * @return mixed
     */
    public static function distributorOrderQuery($distributor_id, $start_date, $end_date)
    {
        if ($start_date && $end_date) {
            $start_date = date("Y-m-d H:i:s", strtotime($start_date));
            $end_date = date("Y-m-d H:i:s", strtotime($end_date));
        }

        $query = DB::table('order_sku_relation')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->join('logistics', 'order.express_id', '=', 'logistics.id')
            ->whereBetween('order_sku_relation.created_at', [$start_date, $end_date])
            ->where('order.distributor_id', '=', $distributor_id)
            ->where('order.status', '=', '10');
        return $query;
    }

}
