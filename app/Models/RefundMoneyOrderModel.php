<?php
/**
 * 退款单
 */
namespace App\Models;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundMoneyOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'refund_money_order';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['number','order_id','out_refund_money_id','amount','status','apply_time','check_time','buyer_id','store_id','store_name','out_order_id','out_buyer_id','out_buyer_name','summary','type'];

    //相对关联到商铺表
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

    //相对关联订单表
    public function order(){
        return $this->belongsTo('App\Models\OrderModel','order_id');
    }

    //一对多关联售后单明细
    public function refundMoneyRelation(){
        return $this->hasMany('App\Models\RefundMoneyRelationModel','refund_money_order_id');
    }

    //一对一关联付款单
    public function paymentOrder()
    {
        return $this->hasOne('App\Models\PaymentOrderModel','target_id');
    }

    /**
     *退款单审核状态 访问器
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        $name = '';
        switch ($this->status){
            case 0:
                $name = '待审核';
                break;
            case 1:
                $name = '同意退款';
                break;
            case 2:
                $name = '拒绝退款';
                break;
            case 3:
                $name = '平台审核通过';
        }
        return $name;
    }

    /**
     * 退款审核处理方法
     *
     * @param int $id 退款单ID
     * @param int $bool 退款审核状态,1:同意退款;2:拒绝退款;
     * @return bool
     */
    public function checkRefund($id,$bool)
    {
        if(!$refund_model = RefundMoneyOrderModel::find($id)){
            return false;
        }

        DB::beginTransaction();
        $refund_model->status = $bool;
        $refund_model->user_id = Auth::user()->id;
        $refund_model->check_time = date("Y-m-d H:i:s");
        if(!$refund_model->save()){
            DB::rollBack();
            return false;
        }
        $order_id = $refund_model->order_id;
        $order = OrderModel::find($order_id);

        if($bool == 1){  //退款审核通过,修改对应订单为取消状态,订单挂起取消
            if(!$order->changeStatus($order_id, 0)){
                DB::rollBack();
                return false;
            }
            if(!$order->cancelSuspend()){
                DB::rollBack();
                return false;
            }

        }else if($bool == 2){  //拒绝退款，订单挂起取消
            if(!$order->cancelSuspend()){
                DB::rollBack();
                return false;
            }

        }

        //店铺平台。1.淘宝；2.京东；3.自营平台
        //同步至平台
        $platform = $refund_model->store->platform;
        switch ($platform){
            case 1:
                //淘宝平台
                DB::rollBack();
                return false;
                break;
            case 2:
                $jdApi = new JdApi();
                $result = $jdApi->replyRefund($id,$bool);
                if(!$result){
                    DB::rollBack();
                    return false;
                }
            case 3:
                //自营
                DB::rollBack();
                return false;
                break;
        }

        DB::commit();
        return true;
    }

    /**
     * 从京东api拉取退款单列表,同步到本地
     *
     * @param $token
     * @param $storeId
     * @return bool
     */
    public function saveRefundList($token,$storeId)
    {
        //设置同步时间缓存
        $applyTimeEndRefund = 'applyTimeEndRefund' . $storeId;
        if(Cache::has($applyTimeEndRefund)){
            $applyTimeStart = Cache::get($applyTimeEndRefund);
        }else{
            $applyTimeStart = date("Y-m-d H:i:s",time() - 3*24*3600);
        }
        $applyTimeEnd = date("Y-m-d H:i:s");
        

        $jdApi = new JdApi();
        if(!$result = $jdApi->pullRefundList($token, $applyTimeStart, $applyTimeEnd)){
            return false;
        }

        foreach ($result as $refund){
            //判断退款单是否已同步，同步则跳过
            $count = RefundMoneyOrderModel::where(['out_refund_money_id' => $refund['id'],'store_id' => $storeId])->count();
            if(0 < $count){
                continue;
            }

            $refund_arr = [];
            $refund_arr['number'] = CountersModel::get_number('DDTK');

            if(!$orderModel = OrderModel::where(['outside_target_id' => $refund['orderId'],'store_id' => $storeId])->first()){
                return false;
            }
            $refund_arr['order_id'] = $orderModel->id;
            $refund_arr['out_refund_money_id'] = $refund['id'];
            $refund_arr['amount'] = ($refund['applyRefundSum'])/100;
            $refund_arr['status'] = $refund['status'];
            $refund_arr['apply_time'] = $refund['applyTime'];
            $refund_arr['check_time'] = $refund['checkTime'];
            $refund_arr['buyer_id'] = '';     //暂时为空，待会员功能完成后添加
            $refund_arr['store_id'] = $storeId;
            $refund_arr['store_name'] = $refund['checkUserName'];
            $refund_arr['out_order_id'] = $refund['orderId'];
            $refund_arr['out_buyer_id'] = $refund['buyerId'];
            $refund_arr['out_buyer_name'] = $refund['buyerName'];

            $refundMoney = new RefundMoneyOrderModel();
            if(!$refundMoney->storeRefund($refund_arr)){
                return false;
            }
        }

        Cache::forever($applyTimeEndRefund,$applyTimeEnd);
        return true;
    }

    /**
     * 添加京东退款单
     *
     * @param array $refund 退款单详细信息
     * @return bool
     */
    public function storeRefund(array $refund)
    {
        DB::beginTransaction();
        if(!$refund_model = RefundMoneyOrderModel::create($refund)){
            DB::rollBack();
            return false;
        }

        $order_id = $refund_model->order_id;
        if(!$order_model = OrderModel::find($order_id)){
            DB::rollBack();
            return false;
        }

        $order_relations = $order_model->orderSkuRelation;
        if($order_relations->isEmpty()){
            DB::rollBack();
            return false;
        }
        //创建退款单明细详情
        foreach ($order_relations as $v){
            $refundMoneyRelation = new RefundMoneyRelationModel();
            $refundMoneyRelation->refund_money_order_id = $refund_model->id;
            $refundMoneyRelation->sku_id = $v->sku_id;
            $refundMoneyRelation->sku_number = $v->sku_number;
            $refundMoneyRelation->quantity = $v->quantity;
            $refundMoneyRelation->price = $v->price;
            $refundMoneyRelation->name = $v->product->title;
            $refundMoneyRelation->mode = $v->productsSku->mode;
            if(!$refundMoneyRelation->save()){
                DB::rollBack();
                return false;
            }
        }

        //挂起对应的订单
        if(!$order_model->suspend()){
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * 退款单待处理数量
     * 
     * @return mixed
     */
    public static function refundMoneyOrderCount()
    {
        return self::where('status',0)->count();
    }

    //自动同步自营商城退款 退货 换货
    public function selfShopSaveRefundList()
    {
        $shopApi = new ShopApi();
        $refundList = $shopApi->getRefundList(1);
        if(!$refundList['success']){
            return false;
        }
        foreach ($refundList['data']['rows'] as $v){
            $this->selfShopSaveRefund($v);
        }
//        $totalRows = $refundList['data']['total_rows'];
        $totalPage = $refundList['data']['total_page'];
        for ($i = 2;$i <= $totalPage; $i++){
            $refundListNew = $shopApi->getRefundList($i);
            if(!$refundListNew['success']){
                return false;
            }
            foreach ($refundListNew['data']['rows'] as $v){
                $this->selfShopSaveRefund($v);
            }
        }

    }

    /**
     * 保存自营商城退款 退货单
     *
     * @param $refund
     * @return bool
     */
    public function selfShopSaveRefund($refund)
    {
        $storeModel = StoreModel::where('platform',3)->first();
        if(!$storeModel){
            Log::error('自营平台商店不存在');
            return false;
        }
        $isset = RefundMoneyOrderModel::where(['out_refund_money_id' => $refund['number'], 'store_id' => $storeModel->id])->count();
        if($isset){
            return false;
        };

        DB::beginTransaction();
        //判断给订单是否有拆单操作，获取对应的订单数据模型
        if(empty($refund['sub_order_id'])){
            $number = $refund['order_rid'];
            $orderModel = OrderModel::where(['outside_target_id' => $number,'store_id' => $storeModel->id])->first();
            if(!$orderModel){
                DB::rollBack();
                Log::info('售后订单对应销售订单不存在,订单:' . $number);
                return false;
            }
        }else{
            $orderModel = OrderModel::where(['number' => $refund['sub_order_id'],'store_id' => $storeModel->id])->first();
            if(!$orderModel){
                DB::rollBack();
                Log::info('售后订单对应(拆)销售订单不存在,订单:' . $refund['sub_order_id']);
                return false;
            }
        }
        //售后订单挂起
        if(!$orderModel->suspend()){
            DB::rollBack();
            Log::error('订单挂起错误：' . $orderModel->number);
            return false;
        }

        //创建退款 退货 返修单
        $refund_arr = [];
        $refund_arr['number'] = CountersModel::get_number('DDTK');
        $refund_arr['order_id'] = $orderModel->id;
        $refund_arr['out_refund_money_id'] = $refund['number'];
        $refund_arr['amount'] = $refund['refund_price'];

        //"stage": 1,        // 进度：0.取消；1.进行中；2.已完成；3.拒绝;
        //status	tinyint(1)	否	0	类型：0.未审核；1. 同意退款；2.拒绝
        switch ($refund['stage']){
            case 0:
                $refund_arr['status'] = 2;
                break;
            case 1:
                $refund_arr['status'] = 0;
                break;
            case 2:
                $refund_arr['status'] = 1;
                break;
            case 3:
                $refund_arr['status'] = 2;
                break;

        }
        $refund_arr['apply_time'] = date("Y-m-d H:i:s",$refund['created_on']);
        $refund_arr['check_time'] = '';
        $refund_arr['buyer_id'] = '';     //暂时为空，待会员功能完成后添加
        $refund_arr['store_id'] = $storeModel->id;
        $refund_arr['store_name'] = $storeModel->name;
        $refund_arr['out_order_id'] = $refund['order_rid'];
        $refund_arr['out_buyer_id'] = '';
        $refund_arr['out_buyer_name'] = $orderModel->buyer_name;
        $refund_arr['summary'] = $refund['reason_label'];
        $refund_arr['type'] = $refund['type'];
        $refundModel = RefundMoneyOrderModel::create($refund_arr);
        if(!$refundModel){
            DB::rollBack();
            Log::info('退款单保存失败');
            return false;
        }

        //退款 退货 返修单 明细
        $refundMoneyRelation = new RefundMoneyRelationModel();
        $refundMoneyRelation->refund_money_order_id = $refundModel->id;
        $refundMoneyRelation->sku_id = '';
        $refundMoneyRelation->sku_number = $refund['sku_number']?$refund['sku_number']:'';
        $refundMoneyRelation->quantity = $refund['product']['quantity'];
        $refundMoneyRelation->price = $refund['product']['sale_price'];
        $refundMoneyRelation->name = $refund['product']['title'];
        $refundMoneyRelation->mode = $refund['product']['sku_name'];
        if(!$refundMoneyRelation->save()){
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * 自动同步各平台未处理售后单状态
     */
    public function autoChangeStatus()
    {
        //获取未处理的售后订单
        $refundModel = RefundMoneyOrderModel::where(['status' => 0])->get();

        foreach($refundModel as $refund){
            $platform = $refund->store->platform;
            /*店铺平台。1.淘宝；2.京东；3.自营平台*/
            switch ($platform){
                case 1:
                    //淘宝平台
                    break;
                case 2:
                    //京东平台
                    break;
                case 3:
                    $this->selfShopChangeStatus($refund);
                    break;
            }

        }
    }

    /**
     * 同步自营平台未处理售后订单状态
     *
     * @param object $refund 售后订单对象
     * @return bool
     */
    protected function selfShopChangeStatus($refund)
    {
        $shopApi = new ShopApi();
        $newRefund = $shopApi->getRefundShow($refund);
        if(!$newRefund['success']){
            Log::warning('获取自营平台售后订单详细信息失败，单号:' . $refund->number . '错误信息：' . $newRefund['message']);
            return false;
        }
        /*自营进度：1.申请中；2.已退款；3.拒绝；*/
        /* erp 0.未审核；1. 同意退款；2.拒绝*/
        if(!key_exists('stage',$newRefund['data'])){
            Log::warning('取自营平台售后订单详细信息 stage字段不存在 单号：' . $refund->number);
            return false;
        }
        switch ($newRefund['data']['stage']){
            case 1:
                return true;
            case 2:
                $this->autoTrueRefundOrder($refund);
                break;
            case 3:
                $this->autoFalseRefundOrder($refund);
                break;
        }
    }

    /**
     * 同步京东平台未处理售后订单
     */
    protected function jdShopChangeStatus($refund)
    {
        $jdApi = new JdApi();
        $newRefund = $jdApi->getRefundShow($refund);
        //
    }

    /**
     * 售后订单状态，同意处理操作
     *
     * @param $refund
     * @param $newRefund
     * @return bool
     */
    protected function autoTrueRefundOrder($refund){
        DB::beginTransaction();

        //售后单同意确认
        if(!$this->trueRefundOrder($refund)){
            DB::rollBack();
            return false;
        }

        $order = $refund->order;
        //判断该订单是否存在其他售后单，如果存在订单继续挂起，否则订单取消挂起
        if(!$this->issetRefundOrder($order)){
            DB::rollBack();
            return false;
        }

        /**
         * 更改对应订单明细商品状态
         */
        if(!$this->orderSkuRelationStatus($order,$refund)){
            DB::rollBack();
            return false;
        }

        /**
         * 生成财务付款单
         */
        //当售后单为退货退款时生成
        if($refund->type == 1 || $refund->type == 2){
            $paymentOrder = new PaymentOrderModel();
            if(!$paymentOrder->refundOrderCreatePaymentOrder($refund->id)){
                DB::rollBack();
                return false;
            }
        }

        DB::commit();
    }

    /**
     * 售后订单状态，拒绝处理操作
     *
     * @param $refund
     * @param $newRefund
     * @return bool
     */
    protected function autoFalseRefundOrder($refund)
    {
        DB::beginTransaction();

        //售后单拒绝确认
        if(!$this->falseRefundOrder($refund)){
            DB::rollBack();
            return false;
        }

        $order = $refund->order;
        //判断该订单是否存在其他售后单，如果存在订单继续挂起，否则订单取消挂起
        if(!$this->issetRefundOrder($order)){
            DB::rollBack();
            return false;
        }

        DB::commit();
    }

    /**
     * 售后单修改为同意状态
     *
     * @param $refund
     * @return bool
     */
    protected function trueRefundOrder($refund)
    {
        $refund->status = 1;
        if(!$refund->save()){
            Log::error('ID:' . $refund->id . '修改售后单同意状态错误');
            return false;
        }
        return true;
    }

    /**
     * 售后单修改为拒绝状态
     *
     * @param $refund
     * @return bool
     */
    protected function falseRefundOrder($refund)
    {
        $refund->status = 2;
        if(!$refund->save()){
            Log::error('ID:' . $refund->id . '修改售后单为拒绝状态错误');
            return false;
        }
        return true;
    }

    /**
     * 判断该订单是否存在其他售后单，如果存在订单继续挂起，否则订单取消挂起
     *
     * @param $order
     * @return bool
     */
    protected function issetRefundOrder($order)
    {
        if(RefundMoneyOrderModel::where(['order_id' => $order->id, 'status' => 0])->count() < 1){
            if(!$order->cancelSuspend()){
                Log::error('order_id' . $order->id. '同步售后单 取消对应订单挂起 错误');
                return false;
            }
        }
        return true;
    }

    /**
     * 更改对应订单明细商品状态
     *
     * @param $order
     * @param $newRefund
     * @return bool
     */
    protected function orderSkuRelationStatus($order,$refund)
    {
        $orderSkuRelation = $order->orderSkuRelation;
        $refundMoneyRelation = $refund->refundMoneyRelation;

        foreach ($refundMoneyRelation as $refundRelation){
            foreach($orderSkuRelation as $v){
                if($v->sku_number == $refundRelation->sku_number){
                    $v->refund_status = $refund->type;
                    if(!$v->save()){
                        Log::error('order_id:' . $order->id . '同步售后单 已退款状态 更改订单明细状态 错误');
                        return false;
                    }
                }
            }
            unset($v);
            reset($orderSkuRelation);
        }

        $newOrderSkuRelation = $order->orderSkuRelation;
        //判断订单明细是否都以退款参数 等于0时 取消订单
        $refund_count = 0;
        foreach($newOrderSkuRelation as $val){
            if($val->refund_status != 1){
                $refund_count = 1;
            }
        }
        //如果订单中商品都已退款  订单状态变更为取消
        if($refund_count == 0){
            $order->status = 0;
            if(!$order->save()){
                Log::error('订单商品全部退款后，更改为取消状态失败');
                return false;
            }
        }
        return true;
    }

}
