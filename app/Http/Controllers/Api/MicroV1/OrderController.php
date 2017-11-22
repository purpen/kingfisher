<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Http\MicroTransformers\OrderTransformer;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class OrderController extends BaseController
{
    /**
     * @api {get} /MicroApi/order/lists 订单列表
     * @apiVersion 1.0.0
     * @apiName Order lists
     * @apiGroup Order
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} status 订单状态 1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
        {
        "data": [
            {
                "id": 29973,
                "number": "DD2017110900002", //订单编码
                "express_id": 3,        // 物流id
                "express_no": null,     //物流单号
                "son_order_count": 1,   //子订单数量
                "total_money": "299.00",    //商品总金额
                "count": 1,                 //商品总数量
                "buyer_name": "刘雷",         //收货人
                "buyer_phone": "13810185655",   //手机号
                "buyer_address": "东城东四路阳光100小区89号楼2单元", //地址
                "buyer_zip": "",    //邮编
                "payment_type": "货到付款", //支付方式
                "order_start_time": "2017-11-09 11:22:47", //下单时间
                "order_send_time": "0000-00-00 00:00:00",   //配送时间
                "invoice_info": "1102261990",   //发票内容
                "invoice_type": "111",          //发票类型
                "invoice_header": "1",          //发票抬头
                "orderSkus": [
                    {
                    "sku_number": "116110490282",   //sku编号
                    "price": "299.00",      //sku价钱
                    "quantity": 1,          //商品数量
                    "image": "https://kg.erp.taihuoniao.com/erp/20170208/589ae1ea6b2ab-p500"    //图片地址
                    "sku_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底" //名称规格

    }
                ]
            },
            {
                "id": 29972,
                "number": "DD2017110900001",
                "express_id": 3,
                "express_no": null,
                "son_order_count": 1,
                "total_money": "699.00",
                "count": 1,
                "buyer_name": "王子乔",
                "buyer_phone": "13405156167",
                "buyer_address": "同心路新北社区卫生服务中心二楼",
                "buyer_zip": "",
                "orderSkus": [
                    {
                    "sku_number": "117102714800",
                    "price": "699.00",
                    "quantity": 1,
                    "image": "http://erp.me/images/default/erp_product1.png"
                    }
                ]
            }
        ],
        "meta": {
            "message": "Success.",
            "status_code": 200,
                "pagination": {
                    "total": 3,
                    "count": 3,
                    "per_page": 15,
                    "current_page": 1,
                    "total_pages": 1,
                    "links": []
                }
            }
        }
     */
    public function lists(Request $request)
    {
        $this->per_page = $request->input('per_page', $this->per_page);
        $user_id = $this->auth_user_id;
        $status = $request->input('status');
        $order = OrderModel::query();
        if($user_id == 0){
            return $this->response->array(ApiHelper::error('请先登录', 404));
        }else{
            $order->where('user_id' , $user_id);
        }

        if(!empty($status)){
            $order->where('status' , $status);
        }
        $orders = $order->orderBy('id', 'desc')
            ->paginate($this->per_page);

        return $this->response->paginator($orders, new OrderTransformer())->setMeta(ApiHelper::meta());

    }


    /**
     * @api {get} /MicroApi/order 订单详情
     * @apiVersion 1.0.0
     * @apiName Order order
     * @apiGroup Order
     *
     * @apiParam {integer} order_id 订单id
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
    {
    "data": [
        {
            "id": 29973,
            "number": "DD2017110900002", //订单编码
            "express_id": 3,        // 物流id
            "express_no": null,     //物流单号
            "son_order_count": 1,   //子订单数量
            "total_money": "299.00",    //商品总金额
            "count": 1,                 //商品总数量
            "buyer_name": "刘雷",         //收货人
            "buyer_phone": "13810185655",   //手机号
            "buyer_address": "东城东四路阳光100小区89号楼2单元", //地址
            "buyer_zip": "",    //邮编
            "payment_type": "货到付款", //支付方式
            "order_start_time": "2017-11-09 11:22:47", //下单时间
            "order_send_time": "0000-00-00 00:00:00",   //配送时间
            "invoice_info": "1102261990",   //发票内容
            "invoice_type": "111",          //发票类型
            "invoice_header": "1",          //发票抬头
            "orderSkus": [
                {
                "sku_number": "116110490282",   //sku编号
                "price": "299.00",      //sku价钱
                "quantity": 1,          //商品数量
                "image": "https://kg.erp.taihuoniao.com/erp/20170208/589ae1ea6b2ab-p500"    //图片地址
                "sku_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底" //名称规格

                }
            ]
        }
    ],
        "meta": {
        "message": "Success.",
        "status_code": 200,

        }
    }
     */

    public function order(Request $request)
    {
        $order_id = $request->input('order_id') ? $request->input('order_id') : 0;
        $orders = OrderModel::where('id', $order_id)->first();
        if($orders){
            return $this->response->item($orders, new OrderTransformer())->setMeta(ApiHelper::meta());
        }else{
            return $this->response->array(ApiHelper::error('没有该订单', 404));

        }

    }

    /**
     * @api {get} /MicroApi/order/delete 删除订单
     * @apiVersion 1.0.0
     * @apiName Order delete
     * @apiGroup Order
     *
     * @apiParam {integer} order_id 订单id
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     *
     */
    public function delete(Request $request)
    {
        $order_id = $request->input('order_id');
        $user_id = $this->auth_user_id;
        $order = OrderModel::where(['id' => $order_id , 'user_id' => $user_id , 'status' => 5])->first();
        if(!$order){
            return $this->response->array(ApiHelper::error('没有权限删除！', 500));
        }else{
            $order->destroy($order_id);
            $order_sku_relation = OrderSkuRelationModel::where('order_id' , $order_id)->get();
            foreach ($order_sku_relation as $order_sku)
            {
                $order_sku->destroy($order_sku->id);
            }
            return $this->response->array(ApiHelper::success());
        }
    }

}
