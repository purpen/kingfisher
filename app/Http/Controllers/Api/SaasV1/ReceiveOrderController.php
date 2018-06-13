<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\ChannelTransformer;
use App\Http\SaasTransformers\ReceiveSkuTransformer;
use App\Models\DistributorPaymentModel;
use Illuminate\Http\Request;

class ReceiveOrderController extends BaseController
{

    /**
     * @api {get} /saasApi/receiveOrder 渠道收款单列表
     * @apiVersion 1.0.0
     * @apiName receiveOrder channel
     * @apiGroup receiveOrder
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
//    品牌付款单列表
    public function channel(Request $request)
    {
        $status = (int)$request->input('status',1);

        $per_page = (int)$request->input('per_page',1);
        $user_id = $this->auth_user_id;
        $query = array();
//        $query['distributor_user_id'] = $user_id;
        if(!empty($status)){
            if ($status === -1) {
                $status = 0;
            }
            $query['status'] = $status;
            $channels = DistributorPaymentModel::where($query)->orderBy('id', 'desc')->paginate($per_page);
        }else{
            $channels = DistributorPaymentModel::orderBy('id', 'desc')->where('status' , $status)->paginate($per_page);
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
//        var_dump($target_id);die;
        $user_id=$this->auth_user_id;
        if (!empty($target_id)){
          $channels = DistributorPaymentModel::where('user_id' , $user_id)->where('id' , $target_id)->first();

            if ($channels){
                $distributor = $channels->paymentReceiptOrderDetail;
//                $distributor = PaymentReceiptOrderDetailModel::where('type',1)->where('target_id',$target_id)->get();
            }
            if (!empty($distributor)){
                $payment_sku = $distributor->toArray();
            }
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
     * "number": "PP2018061100012",  //单号
     * "distributor_user_id": "小米科技",  //分销商ID
     * "user_id": 1,  //操作人
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
        echo 'qye';


    }


    public function download(Request $request)
    {
        echo '下载';
    }



}