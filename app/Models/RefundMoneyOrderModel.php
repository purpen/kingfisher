<?php
/**
 * 退款单
 */
namespace App\Models;

use App\Helper\JdApi;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
    protected $fillable = ['order_id','out_refund_money_id','amount','status','apply_time','check_time','buyer_id','store_id','store_name','out_order_id','out_buyer_id','out_buyer_name'];

    //相对关联到商铺表
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

    //相对关联订单表
    public function order(){
        return $this->belongsTo('App\Models\OrderModel','order_id');
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
     * 添加退款单
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
        //挂起对应的订单
        if(!$order_model->suspend()){
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }


    /**
     * 退款审核处理方法
     *
     * @param int $id 退款单ID
     * @param int $bool 退款审核状态,0:拒绝退款;1:同意退款;
     * @return bool
     */
    public function checkRefund($id,$bool)
    {
        DB::beginTransaction();
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

        if($bool == 2){  //退款审核通过,修改对应订单未取消状态,订单挂起取消
            if(!$order->changeStatus($order_id, 0)){
                DB::rollBack();
                return false;
            }
            if(!$order->cancelSuspend()){
                DB::rollBack();
                return false;
            }

        }else if($bool == 0){  //拒绝退款，订单挂起取消
            if(!$order->cancelSuspend()){
                DB::rollBack();
                return false;
            }

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
}
