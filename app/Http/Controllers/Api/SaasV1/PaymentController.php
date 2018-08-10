<?php
namespace App\Http\Controllers\Api\SaasV1;


use App\Http\ApiHelper;
use App\Http\SaasTransformers\OrderTransformer;
use App\Http\SaasTransformers\PaymentSkuTransformer;
use App\Http\SaasTransformers\PaymentTransformer;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\PaymentReceiptOrderDetailModel;
use App\Models\ProductsSkuModel;
use App\Models\SupplierModel;
use App\Models\SupplierReceiptModel;
use Illuminate\Http\Request;

class PaymentController extends BaseController{

    /**
     * @api {get} /saasApi/payment 品牌付款单列表
     * @apiVersion 1.0.0
     * @apiName Payment payment
     * @apiGroup Payment
     *
     * @apiParam {integer} status 状态: 0.默认 1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
    {
    "data": [
    {
    "id": 2,
    "number": "PP2018061100012",  //单号
    "supplier_user_id": "魅族科技",  //供货商ID
    "created_at": "0000-00-00 00:00:00",  //创建时间
    "total_price": 1000,  //总金额
    "user_id": 1,  //操作人
    "status": 2,  //状态: 0.默认 1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
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
    public function payment(Request $request)
    {
        $status = (int)$request->input('status',1);
        $per_page = (int)$request->input('per_page',1);
        $user_id = $this->auth_user_id;
        $supplier_user_id = $request->input('supplier_user_id');
////        $supplier=SupplierModel::where('id',$supplier_user_id)->first();
////        $supplier['name'] = $supplier->nam;
             $query = array();
             $query['supplier_user_id'] = $supplier_user_id;
        if(!empty($status)){
            if ($status === -1) {
                $status = 0;
            }
            $query['status'] = $status;
            $payment_skus = SupplierReceiptModel::where($query)->orderBy('id', 'desc')->paginate($per_page);
        }else{
            $payment_skus = SupplierReceiptModel::orderBy('id', 'desc')->where('supplier_user_id' , $supplier_user_id)->paginate($per_page);
        }
        return $this->response->paginator($payment_skus, new PaymentTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /saasApi/payment/info 品牌付款单详情
     * @apiVersion 1.0.0
     * @apiName Payment info
     * @apiGroup Payment
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
     * "total_price":                              //总价
     * },
     * "meta": {
     * "message": "Success.",
     * "status_code": 200
     * }
     * }
     **/

    public function info(Request $request)
    {
        $target_id=(int)$request->input('target_id',2);
        $user_id=$this->auth_user_id;

        $type = 2;
        if (!empty($target_id)){

            $payment_skus = SupplierReceiptModel::where('user_id' , $user_id)->where('id' , $target_id)->first();


            if ($payment_skus){
//                $payments = $payment_skus->paymentReceiptOrderDetail;
                $payments = PaymentReceiptOrderDetailModel::where('type',$type)->where('target_id',$target_id)->get();


            }
            if (!empty($payments)){
                $payment_sku = $payments->toArray();
                $zongjine = 0;
                foreach ($payment_sku as $key=>$v){

                    $payment_sku[$key]['numbers'] = $payment_skus['number'];
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
                ->join('supplier_receipt', 'supplier_receipt.id', '=', 'order_sku_relation.supplier_receipt_id')
                ->join('order','order.id','=','order_sku_relation.order_id')
                ->where(['order_sku_relation.supplier_receipt_id'=>$target_id])
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
            return $this->response->array(ApiHelper::error('付款单id不能为空', 200));
        }

        return $this->response->array(ApiHelper::success('Success', 200, $data));

//        return $this->response->item($data, new PaymentSkuTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {post} /saasApi/sure 品牌付款单确认
     * @apiVersion 1.0.0
     * @apiName Payment sure
     * @apiGroup Payment
     *
     * @apiParam {integer} id 付款单ID
     * @apiParam {integer} status 状态: 0.默认 1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     *"data": [
     * {
     * "id": 2,
     * "status": 2,  //状态: 0.默认 1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
     * },
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200
     * }
     * }
     *
     */
    //在前台页面点击通过审核就可以确认完成
    public function sure(Request $request)
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
            $res = DB::table('supplier_receipt')
                ->where('id', $id)
                ->update(['status' => $status]);

        }
        return $this->response->array(ApiHelper::success('Success.', 200, ""));

    }
}