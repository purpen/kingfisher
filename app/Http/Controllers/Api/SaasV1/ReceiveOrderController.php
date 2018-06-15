<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\ChannelTransformer;
use App\Http\SaasTransformers\ReceiveSkuTransformer;
use App\Models\DistributorPaymentModel;
use App\Models\PaymentReceiptOrderDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiveOrderController extends BaseController
{

    /**
     * @api {get} /saasApi/receiveOrder 渠道收款单列表
     * @apiVersion 1.0.0
     * @apiName ReceiveOrder receiveOrder
     * @apiGroup ReceiveOrder
     *
     * @apiParam {integer} status 状态: 0.默认 1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
    {
    "data": [
    {
    "id": 2,
    "number": "PP2018061100012",  //单号
    "distributor_user_id": "魅族科技",  //渠道商ID
    "created_at": "0000-00-00 00:00:00",  //创建时间
    "price": 1000,  //总金额
    "user_id": 1,  //操作人
    "status": 2,  //状态: 0.默认 1.待负责人确认 2.待分销商确认 3.待确认付款 4.完成
    },
    ],
    "meta": {
    "message": "Success.",
    "status_code": 200,
    "pagination": {
    "total": 1,
    "count": 1,
    "per_page": 10,
    "current_page": 1,
    "total_pages": 1,
    "links": []
    }
    }
    }
     *
     *
     */
//    渠道收款单列表
    public function receiveOrder(Request $request)
    {
        $status = (int)$request->input('status',1);

        $per_page = (int)$request->input('per_page',1);
        $user_id = $this->auth_user_id;
        $query = array();
        $query['distributor_user_id'] = $user_id;
        if(!empty($status)){
            if ($status === -1) {
                $status = 0;
            }
            $query['status'] = $status;
            $channels = DistributorPaymentModel::where($query)->orderBy('id', 'desc')->paginate($per_page);
        }else{
            $channels = DistributorPaymentModel::orderBy('id', 'desc')->where('distributor_user_id' , $user_id)->paginate($per_page);
        }
        return $this->response->paginator($channels, new ChannelTransformer())->setMeta(ApiHelper::meta());
    }




    /**渠道收款单详情
     * @apiVersion 1.0.0
     * @apiName receiveOrder detail
     * @apiGroup receiveOrder
     *
     * @apiParam {integer} target_id 付款单ID
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": {
     * "id": 2,
     * "type": 2,                              // 类型：1.渠道付款单ID 2.供应商收款单ID
     * "target_id": "116110418454",           // 收、付款单ID
     * "skuID": "智能硬件",                    //skuID
     * "sku_number": "12332111",             //sku编号
     * "sku_name": "小米",                   //平台返回商品名 sku规格
     * "price": "200.00",                   // 单价
     * "quantity": "123",                  // 数量
     * "favorable": [   // 优惠信息
     * {
     * "number": "116110436487",                   //促销数量
     * "price": "123",                             // 促销价格
     * "start_time": "0000-00-00 00:00:00"         // 促销开始时间
     * "end_time": "0000-00-00 00:00:00",          // 促销结束时间
     * },
     * ]
     * "price":                              //总价
    //     * "number":827472742                          //订单号
    //     * "outside_target_id":2134112                 //站外订单号
     * },
     * "meta": {
     * "message": "Success.",
     * "status_code": 200
     * }
     * }
     **/

    public function detail(Request $request)
    {
        $target_id=(int)$request->input('target_id',2);
        $user_id=$this->auth_user_id;

        $type = 1;
        if (!empty($target_id)){
            $channels = DistributorPaymentModel::where('user_id' , $user_id)->where('id' , $target_id)->first();

            if ($channels){
//                $distributor = $channels->paymentReceiptOrderDetail;
                $distributor = PaymentReceiptOrderDetailModel::where('type',$type)->where('target_id',$target_id)->get();
            }
            if (!empty($distributor)){
                $payment_sku = $distributor->toArray();
                $zongjine = 0;
                foreach ($payment_sku as $key=>$v){
                    $payment_sku[$key]['numbers'] = $channels['number'];
                    $payment_sku[$key]['goods_money'] = sprintf("%.2f",$v['quantity'] * $v['price']);
                    $favorable = json_decode($v['favorable'],true);
                    $payment_sku[$key]['start_time'] = $favorable['start_time'];
                    $payment_sku[$key]['end_time'] = $favorable['end_time'];
                    $payment_sku[$key]['number'] = $favorable['number'];
                    $payment_sku[$key]['prices'] = $favorable['price'];
                    $payment_sku[$key]['promotion_money'] = ($v['price']-$favorable['price']) * $v['quantity'];
                    $payment_sku[$key]['xiaoji'] = $payment_sku[$key]['goods_money'] - $payment_sku[$key]['promotion_money'];
                    $zongjine += $payment_sku[$key]['xiaoji'];
                    unset($payment_sku[$key]['favorable']);
                }

                $payment_sku['total'] = sprintf("%.2f",$zongjine);
            }

            $payment= new OrderSkuRelationModel();
            $sku_relation = $payment
                ->join('distributor_payment', 'distributor_payment.id', '=', 'order_sku_relation.distributor_payment_id')
                ->join('order','order.id','=','order_sku_relation.order_id')
                ->where(['order_sku_relation.distributor_payment_id'=>$target_id])
                ->select([
                    'order.number',
                    'order.outside_target_id',
                    'supplier_receipt.total_price',
                    'order_sku_relation.sku_name',
                    'order_sku_relation.quantity',
                    'order_sku_relation.price',
                    'order_sku_relation.sku_number',
                    'order_sku_relation.supplier_price',
                ])

                ->get();
            $data['payment_sku'] = $payment_sku;
            $data['sku_relation'] = $sku_relation->toArray();
        }else{
            return $this->response->array(ApiHelper::error('收款单id不能为空', 200));
        }
        return $this->response->item($channels, new ReceiveSkuTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {post} /saasApi/confirm 渠道收款单确认
     * @apiVersion 1.0.0
     * @apiName receiveOrder confirm
     * @apiGroup receiveOrder
     *
     * @apiParam {integer} status 状态: 0.默认 1.待负责人确认 2.待分销商确认 3.待确认付款 4.完成
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     *"data": [
     * {
     * "id": 2,
    //     * "number": "PP2018061100012",  //单号
    //     * "distributor_user_id": "小米科技",  //分销商ID
    //     * "user_id": 1,  //操作人
     * "status": 2,  //状态: 0.默认 1.待负责人确认 2.待分销商确认 3.待确认付款 4.完成
     * },
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200
     * }
     * }
     *
     */
    //导出明细 或者在前台页面点击通过审核就可以确认完成
    public function confirm(Request $request)
    {
        //修改status
//        $target_id = $request->input('target_id');
//        $supplier_receipt = SupplierReceiptModel::where('id',$target_id)->first();
        $id = $request->input('id');
        $status = $request->input('status');
        if(!is_numeric($id) || $id == 0){

            return $this->response->array(ApiHelper::error('参数有误', 200));
        }
        if(!is_numeric($status)){

            return $this->response->array(ApiHelper::error('参数有误', 200));
        }

        if($status == 2) {
            $data = ['status' => 3];
            $res = DB::table('distributor_payment')
                ->where('id', $id)
                ->update(['status' => $status]);

        }
        return $this->response->array(ApiHelper::success('Success.', 200, ""));

    }



    /**渠道收款单导出
     * @apiVersion 1.0.0
     * @apiName receiveOrder download
     * @apiGroup receiveOrder
     *
     * @apiParam {integer} target_id 付款单ID
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": {
     * "id": 2,
     * "distributor_user_id"                           //渠道商ID
     * "sku_number": "12332111",                      //sku编号
     * "sku_name": "小米",                            //平台返回商品名 sku规格
     * "price":                                     //总价格
     * "price as prices":                          //单价
     * "distributor_price":                       //分销商促销价
     * "number":827472742                        //订单号
     * "outside_target_id":2134112              //站外订单号
     * },
     * "meta": {
     * "message": "Success.",
     * "status_code": 200
     * }
     * }
     **/

    public function download(Request $request)
    {
        $id = $request->input('id');
        $user_id = $this->auth_user_id;

        $details = DB::table('order_sku_relation')
            ->join('distributor_payment', 'distributor_payment.id', '=', 'order_sku_relation.distributor_payment_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->where('distributor_payment.id', '=', $id)
            ->select([
                'order.number',
                'order.outside_target_id',
                'distributor_payment.distributor_user_id',
                'distributor_payment.price',
                'order_sku_relation.sku_name',
                'order_sku_relation.quantity',
                'order_sku_relation.price',
                'order_sku_relation.sku_number',
                'order_sku_relation.distributor_price',
            ])
            ->get();
        return $this->response->array(ApiHelper::success('Success', 200, $details));
    }




}