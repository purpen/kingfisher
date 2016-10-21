<?php
/**
 * 订单表
 */
namespace App\Models;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'order';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['type', 'store_id', 'payment_type', 'outside_target_id', 'express_id', 'freight','buyer_summary', 'seller_summary', 'buyer_name', 'buyer_phone', 'buyer_tel', 'buyer_zip', 'buyer_address', 'user_id', 'status', 'total_money', 'discount_money', 'pay_money','number','count','storage_id'];

    //相对关联到商铺表
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

    //相对关联到user用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //相对关联到物流表
    public function logistics(){
        return $this->belongsTo('App\Models\LogisticsModel','express_id');
    }

    //相对关联到仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联调拨表
    public function outWarehouses(){
        return $this->hasOne('App\Models\OutWarehousesModel','target_id');
    }

    //一对一关联收款单表
    public function receiveOrder(){
        return $this->hasOne('App\Models\ReceiveOrderModel','target_id');
    }

    //一对一退款单
    public function refundMoneyOrder(){
        return $this->hasOne('App\Models\RefundMoneyOrderModel','order_id');
    }

    /**
     * 订单状态status 访问修改器   状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @param $value
     * @return string
     */
    public function getStatusValAttribute()
    {
        switch ($this->status){
            case 0:
                $status = '取消';
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
                $status = '完成';
                break;
            default:
                $status = '取消';
        }
        return $status;
    }

    /**
     * 付款类型访问修改器
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
     * 修改订单状态
     * @param $order_id
     * @param $status
     * @return bool
     */
    public function changeStatus($order_id,$status)
    {
        $order_id = (int)$order_id;

        $status_arr = [0,1,5,8,10,20];
        if(!in_array($status, $status_arr)){
            return false;
        }

        if(empty($order_id)){
            return false;
        }
        if(!$order_model = self::find($order_id)){
            return false;
        }
        $order_model->status = $status;
        if(!$order_model->save()){
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
        if(!$this->save()){
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
        if(!$this->save()){
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
            foreach ($order_info['item_info_list'] as $item_info){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_number = $item_info['outer_sku_id'];
                $order_sku_model->sku_name = $item_info['sku_name'];

                if($skuModel = ProductsSkuModel::where('number',$item_info['outer_sku_id'])->first()){
                    $order_sku_model->sku_id = $skuModel->id;
                    $order_sku_model->product_id = $skuModel->product->id;
                }else{
                    $order_sku_model->sku_id = '';
                    $order_sku_model->product_id = '';
                }
               
                $order_sku_model->quantity = $item_info['item_total'];
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
        if($data[0] === false){
            Log::error($data[1]);
        }
        $order_list = $data[1];
        DB::beginTransaction();
        foreach ($order_list as $order){
            $count = OrderModel::where(['store_id' => $storeId,'outside_target_id' => $order['rid']])->count();
            if($count > 0){
                continue;
            }

            $order_model = new OrderModel();

            $order_model->number = CountersModel::get_number('DD');
            $order_model->outside_target_id = $order['rid'];
            $order_model->type = 3;   //下载订单
            $order_model->store_id = $storeId;

            $storeStorageLogistic = $store->storeStorageLogistic;

            if(!$storeStorageLogistic){
                Log::error('店铺未设置默认仓库或物流');
                DB::roolBack();
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
            $order_model->buyer_county = '';
            $order_model->buyer_summary = '';
            $order_model->order_start_time = $order['created_at'];
            $order_model->invoice_info = $this->invoice($order['invoice_caty'],$order['invoice_title'] ,$order['invoice_content'] );
//            $order_model->seller_summary = $order_info['vender_remark'];
            $order_model->status = 5;

            if(!$order_model->save()){
                DB::roolBack();
                return false;
            }
            $order_id = $order_model->id;
            foreach ($order['items'] as $item){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_number = $item['sku'];
                $order_sku_model->sku_name = $item['name'] . $item['sku_name'];

                if($skuModel = ProductsSkuModel::where('number',$item['sku'])->first()){
                    $order_sku_model->sku_id = $skuModel->id;
                    $order_sku_model->product_id = $skuModel->product->id;
                }else{
                    $order_sku_model->sku_id = '';
                    $order_sku_model->product_id = '';
                }

                $order_sku_model->quantity = $item['quantity'];
                $order_sku_model->price = $item['price'];
                $order_sku_model->discount = $item['price'] - $item['sale_price'];
                if(!$order_sku_model->save()){
                    DB::rollBack();
                    return false;
                }
            }

        }

        DB::commit();
        
    }


    /**
     * 自营店铺发票信息拼接
     *
     * @param $invoice_caty
     * @param $invoice_title
     * @param $invoice_content
     * @return string
     */
    public function invoice($invoice_caty,$invoice_title,$invoice_content)
    {
        switch ($invoice_caty){
            case 1:
                $invoice_caty = '个人';
                break;
            case 2:
                $invoice_caty = '单位';
                break;
            default:
                $invoice_caty = '';
        }

        switch ($invoice_content){
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
                    //自营平台
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


    //打印发货单
    public function showSendOrder(){
        
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
