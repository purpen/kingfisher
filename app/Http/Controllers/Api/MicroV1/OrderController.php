<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Http\MicroTransformers\OrderTransformer;
use App\Models\CartModel;
use App\Models\ChinaCityModel;
use App\Models\CountersModel;
use App\Models\DeliveryAddressModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Illuminate\Support\Facades\Log;
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
        $order = OrderModel::where(['id' => $order_id , 'user_id' => $user_id])->first();
        if(!$order){
            return $this->response->array(ApiHelper::error('没有权限删除！', 403));
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


    /**
     * @api {post} /MicroApi/order/store 直接下单
     * @apiVersion 1.0.0
     * @apiName Order orderStore
     * @apiGroup Order
     *
     * @apiParam {integer} sku_id SKU_id
     * @apiParam {integer} n 购买数量 默认值：1
     * @apiParam {integer} channel_id  渠道方ID
     * @apiParam {string} summary 备注
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function store(Request $request)
    {
        $user_id = $this->auth_user_id;
        $sku_id = $request->input('sku_id') ? (int)$request->input('sku_id') : 0;
        $n = $request->input('n') ? (int)$request->input('n') : 1;
        $channel_id = $request->input('channel_id') ? (int)$request->input('channel_id') : 0;

        if (empty($sku_id)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 412));
        }
        $number = CountersModel::get_number('DD');
        $productSku = ProductsSkuModel::where('id' , (int)$sku_id)->first();
        if(empty($productSku)){
            return $this->response->array(ApiHelper::error('没有该sku！', 404));
        }
        $order = new OrderModel();
        $order->user_id = $user_id;
        $order->status = 1;
        $order->count = $n;
        $order->type = 7;
        $order->from_type = 3;
        $order->user_id_sales = 1;
        $order->number = $number;
        $order->order_start_time = date("Y-m-d H:i:s");
        $order->total_money = (int)($productSku->price) * $n;

        $address = DeliveryAddressModel::where('user_id' , $user_id)->where('is_default' , 0)->first();
        if(!$address){
            return $this->response->array(ApiHelper::error('收货地址不存在！', 402));
        }


        $order->buyer_name = $address->name;
        $order->buyer_phone = $address->phone;
        $order->buyer_address = $address->address;
        $order->buyer_zip = $address->zip;

        //省
        $province_id = $address->province_id;
        if($province_id !== 0){
            $buyer_province = ChinaCityModel::where('id' , $province_id)->first();
            $order->buyer_province = $buyer_province->name;
        }else{
            $order->buyer_province = '';
        }
        //市
        $city_id = $address->city_id;
        if($city_id !== 0){
            $buyer_city = ChinaCityModel::where('id' , $city_id)->first();
            $order->buyer_city = $buyer_city->name;
        }else{
            $order->buyer_city = '';
        }
        //县
        $county_id = $address->county_id;
        if($county_id !== 0){
            $buyer_county = ChinaCityModel::where('id' , $county_id)->first();
            $order->buyer_county = $buyer_county->name;
        }else{
            $order->buyer_county = '';
        }
        //镇
        $township_id = $address->town_id;
        if($township_id !== 0){
            $buyer_township = ChinaCityModel::where('id' , $township_id)->first();
            $order->buyer_township = $buyer_township->name;
        }else{
            $order->buyer_township = '';
        }


        $order->summary = $request->input('summary');
        if(!$order->save()){
            return $this->response->array(ApiHelper::error('订单保存失败！', 500));
        }

        $order_id = $order->id;

        $order_sku_model = new OrderSkuRelationModel();
        $order_sku_model->order_id = $order_id;
        $order_sku_model->sku_id = $sku_id;
        $order_sku_model->sku_number = $productSku->number;
        $order_sku_model->sku_name =  $productSku->product->title . '--' . $productSku->mode;;
        $order_sku_model->product_id = $productSku->product->id;
        $order_sku_model->quantity = $n;
        $order_sku_model->price = $productSku->price;
        $order_sku_model->discount = 0;
        $order_sku_model->channel_id = $channel_id;

        if(!$order_sku_model->save()){
            return $this->response->array(ApiHelper::error('订单详情保存失败！', 500));
        }

        return $this->response->array(ApiHelper::success());

    }


    /**
     * @api {post} /MicroApi/order/microStore 购物车下单
     * @apiVersion 1.0.0
     * @apiName Order orderMicroStore
     * @apiGroup Order
     *
     * @apiParam {string} cart_id 购物车id
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
     *
     */
    public function microStore(Request $request)
    {
        $carts = explode(',',$request->input('cart_id'));
        $user_id = $this->auth_user_id;
        $total_price = 0;
        $total_n = 0;
        //计算购物车全部商品价格数量
        foreach($carts as $cart_id)
        {
            $cart = CartModel::where('id' , $cart_id)->first();
            if($cart){
                $price = $cart->price;
                $n = $cart->n;
                $total_n += $n;
                $total_price += $price * $n;
            }else{
                continue;
            }
        }
        $number = CountersModel::get_number('DD');
        //保存订单
        $order = new OrderModel();
        $order->user_id = $user_id;
        $order->status = 1;
        $order->count = $total_n;
        $order->type = 7;
        $order->from_type = 3;
        $order->user_id_sales = 1;
        $order->number = $number;
        $order->order_start_time = date("Y-m-d H:i:s");
        $order->total_money = $total_price;
        //验证有无收获地址
        $address = DeliveryAddressModel::where('user_id' , $user_id)->where('is_default' , 0)->first();
        if(!$address){
            return $this->response->array(ApiHelper::error('收货地址不存在！', 402));
        }


        $order->buyer_name = $address->name;
        $order->buyer_phone = $address->phone;
        $order->buyer_address = $address->address;
        $order->buyer_zip = $address->zip;

        //省
        $province_id = $address->province_id;
        if($province_id !== 0){
            $buyer_province = ChinaCityModel::where('id' , $province_id)->first();
            $order->buyer_province = $buyer_province ? $buyer_province->name : '';
        }else{
            $order->buyer_province = '';
        }
        //市
        $city_id = $address->city_id;
        if($city_id !== 0){
            $buyer_city = ChinaCityModel::where('id' , $city_id)->first();
            $order->buyer_city = $buyer_city ? $buyer_city->name : '';
        }else{
            $order->buyer_city = '';
        }
        //县
        $county_id = $address->county_id;
        if($county_id !== 0){
            $buyer_county = ChinaCityModel::where('id' , $county_id)->first();
            $order->buyer_county = $buyer_county ? $buyer_county->name : '';
        }else{
            $order->buyer_county = '';
        }
        //镇
        $township_id = $address->town_id;
        if($township_id !== 0){
            $buyer_township = ChinaCityModel::where('id' , $township_id)->first();
            $order->buyer_township = $buyer_township ? $buyer_township->name : '';
        }else{
            $order->buyer_township = '';
        }

        if(!$order->save()){
            return $this->response->array(ApiHelper::error('订单保存失败！', 500));
        }

        $order_id = $order->id;
        //购物车中每个商品保存到订单明细中
        foreach($carts as $cart_id)
        {
            $cart = CartModel::where('id' , $cart_id)->first();
            if($cart){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_id = $cart->sku_id;
                $order_sku_model->sku_number = $cart->sku_number;
                $productSku = ProductsSkuModel::where('id' , (int)($cart->sku_id))->first();
                if($productSku){
                    $order_sku_model->sku_name =  $productSku->product->title . '--' . $productSku->mode;;
                }else{
                    $order_sku_model->sku_name = '';
                }
                $order_sku_model->product_id = $cart->product_id;
                $order_sku_model->quantity = $cart->n;
                $order_sku_model->price = $cart->price;
                $order_sku_model->discount = 0;
                $order_sku_model->channel_id = $cart->channel_id;

                if(!$order_sku_model->save()){
                    return $this->response->array(ApiHelper::error('订单详情保存失败！', 500));
                }
                $cart->destroy($cart->id);

            }else{
                continue;
            }


        }


        return $this->response->array(ApiHelper::success());

    }

}
