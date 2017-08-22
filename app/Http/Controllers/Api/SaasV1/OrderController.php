<?php
namespace App\Http\Controllers\Api\SaasV1;


use App\Http\ApiHelper;
use App\Http\SaasTransformers\OrderTransformer;
use App\Models\OrderModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends BaseController
{

    /**
     * @api {post} /saasApi/order/excel 订单导入
     * @apiVersion 1.0.0
     * @apiName Order excel
     * @apiGroup Order
     *
     * @apiParam {integer} excel_type 订单类型 1.太火鸟 2.京东 3.淘宝
     * @apiParam {file} file 文件
     * @apiParam {string} token token
     *
     *
     */
    public function excel(Request $request)
    {
        $user_id = $this->auth_user_id;
        $excel_type = $request->input('excel_type') ? $request->input('excel_type') : 0;
        if(!in_array($excel_type , [1,2,3])){
            return $this->response->array(ApiHelper::error('请选择订单类型', 200));
        }
        if($excel_type == 1){
            if(!$request->hasFile('file') || !$request->file('file')->isValid()){
                return $this->response->array(ApiHelper::error('上传失败', 401));
            }
            $file = $request->file('file');
            //读取execl文件
            $results = Excel::load($file, function($reader) {
            })->get();
            $results = $results->toArray();
            foreach ($results as $data)
            {
                $result = OrderModel::zyInOrder($data ,$user_id);
                if($result[0] === false){
                    return $this->response->array(ApiHelper::error($result[1], 200));
                }
            }
            return $this->response->array(ApiHelper::success('保存成功', 200));
        }
        if($excel_type == 2){
//            $store_id = $request->input('store_id');
//            $product_id = $request->input('product_id');
//            if(empty($store_id)){
//                return $this->response->array(ApiHelper::error('店铺id不能为空', 200));
//
//            }
//            if(empty($product_id)){
//                return $this->response->array(ApiHelper::error('商品id不能为空', 200));
//
//            }
            $product = ProductsModel::where('id' , $product_id)->first();
            $product_number = $product->number;
            if(!$request->hasFile('file') || !$request->file('file')->isValid()){
                return $this->response->array(ApiHelper::error('上传失败', 401));
            }
            $file = $request->file('file');
            //读取execl文件
            $results = Excel::load($file, function($reader) {
            })->get();
            $results = $results->toArray();

            DB::beginTransaction();
            $new_data = [];
            foreach ($results as $data)
            {
                if(!empty($data['档位价格']) && !in_array($data['档位价格'] , $new_data)){
                    $sku_number  = 1;
                    $sku_number .= date('ymd');
                    $sku_number .= sprintf("%05d", rand(1,99999));
                    $product_sku = new ProductsSkuModel();
                    $product_sku->product_id = $product_id;
                    $product_sku->product_number = $product_number;
                    $product_sku->number = $sku_number;
                    $product_sku->price = $data['档位价格'];
                    $product_sku->bid_price = $data['档位价格'];
                    $product_sku->cost_price = $data['档位价格'];
                    $product_sku->mode = '众筹款';
                    $product_sku->user_id = $user_id;
                    $product_sku->save();
                    $product_sku_id = $product_sku->id;
                    $new_data[] = $product_sku->price;
                }else{
                    $product_sku = ProductsSkuModel::where('price' , $data['档位价格'])->where('mode' , '众筹款')->first();
                    $product_sku_id = $product_sku->id;
                }
                $result = OrderModel::zcInOrder($data , $store_id , $product_id , $product_sku_id ,$user_id);
                if(!$result[0]){
                    DB::rollBack();
                    return $this->response->array(ApiHelper::error('保存失败', 200));
                }
            }

            DB::commit();

            return $this->response->array(ApiHelper::success('保存成功', 200));
        }
    }

    /**
     * @api {get} /saasApi/orders 订单列表
     * @apiVersion 1.0.0
     * @apiName Order orders
     * @apiGroup Order
     *
     * @apiParam {integer} status 状态: 0.全部； -1.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
     {
        "data": [
            {
                "id": 25918,
                "number": "11969757068000",
                "buyer_name": "冯宇",
                "buyer_phone": "13588717651",
                "buyer_address": "长庆街青春坊16幢2单元301室",
                "pay_money": "119.00",
                "user_id": 19,
                "count": 1,
                "logistics_name": "",
                "express_no": "需要您输入快递号",
                "order_start_time": "0000-00-00 00:00:00",
                "buyer_summary": null,
                "seller_summary": "",
                "status": 8,
                "status_val": "待发货",
                "buyer_province": "浙江",
                "buyer_city": "杭州市",
                "buyer_county": "下城区",
                "buyer_township": ""
            },
            {
                "id": 25917,
                "number": "11969185718000",
                "buyer_name": "冯宇",
                "buyer_phone": "13588717651",
                "buyer_address": "长庆街青春坊16幢2单元301室",
                "pay_money": "119.00"
                "user_id": 19,
                "count": 1,
                "logistics_name": "",
                "express_no": "需要您输入快递号",
                "order_start_time": "0000-00-00 00:00:00",
                "buyer_summary": null,
                "seller_summary": "",
                "status": 8,
                "status_val": "待发货",
                "buyer_province": "浙江",
                "buyer_city": "杭州市",
                "buyer_county": "下城区",
                "buyer_township": ""
            }
        ],
        "meta": {
            "message": "Success.",
            "status_code": 200,
                "pagination": {
                "total": 717,
                "count": 2,
                "per_page": 2,
                "current_page": 1,
                "total_pages": 359,
                "links": {
                    "next": "http://erp.me/saasApi/orders?page=2"
                }
            }
        }
     }
     *
     */
    public function orders(Request $request)
    {
        $status = (int)$request->input('status', 0);
        $per_page = (int)$request->input('per_page', 10);
        $user_id = $this->auth_user_id;
        $query = array();
        $query['user_id'] = $user_id;
        if(!empty($status)){
            if ($status === -1) {
              $status = 0;
            }
            $query['status'] = $status;
            $orders = OrderModel::where($query)->orderBy('id', 'desc')->paginate($per_page);
        }else{
            $orders = OrderModel::orderBy('id', 'desc')->where('user_id' , $user_id)->paginate($per_page);
        }

        return $this->response->paginator($orders, new OrderTransformer())->setMeta(ApiHelper::meta());


    }

    /**
     * @api {get} /saasApi/orders 最新10条订单
     * @apiVersion 1.0.0
     * @apiName Order newOrders
     * @apiGroup Order
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 25918,
                    "number": "11969757068000",
                    "buyer_name": "冯宇",
                    "buyer_phone": "13588717651",
                    "buyer_address": "长庆街青春坊16幢2单元301室",
                    "pay_money": "119.00",
                    "user_id": 19,
                    "count": 1,
                    "logistics_name": "",
                    "express_no": "需要您输入快递号",
                    "order_start_time": "0000-00-00 00:00:00",
                    "buyer_summary": null,
                    "seller_summary": "",
                    "status": 8,
                    "status_val": "待发货",
                    "buyer_province": "浙江",
                    "buyer_city": "杭州市",
                    "buyer_county": "下城区",
                    "buyer_township": ""
                },
                {
                    "id": 25917,
                    "number": "11969185718000",
                    "buyer_name": "冯宇",
                    "buyer_phone": "13588717651",
                    "buyer_address": "长庆街青春坊16幢2单元301室",
                    "pay_money": "119.00",
                    "user_id": 19,
                    "count": 1,
                    "logistics_name": "",
                    "express_no": "需要您输入快递号",
                    "order_start_time": "0000-00-00 00:00:00",
                    "buyer_summary": null,
                    "seller_summary": "",
                    "status": 8,
                    "status_val": "待发货",
                    "buyer_province": "浙江",
                    "buyer_city": "杭州市",
                    "buyer_county": "下城区",
                    "buyer_township": ""
                }
            ],
            "meta": {
                "message": "Success.",
                "status_code": 200,
                "pagination": {
                    "total": 717,
                    "count": 2,
                    "per_page": 2,
                    "current_page": 1,
                    "total_pages": 359,
                    "links": {
                        "next": "http://erp.me/saasApi/orders?page=2"
                    }
                }
            }
        }
     */
    public function newOrders()
    {
        $user_id = $this->auth_user_id;
        $orders = OrderModel::limit(10)->where('user_id' , $user_id)->orderBy('id', 'desc')->get();
        return $this->response->paginator($orders, new OrderTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /saasApi/order 订单详情
     * @apiVersion 1.0.0
     * @apiName Order order
     * @apiGroup Order
     *
     * @apiParam {integer} order_id 订单id
     * @apiParam {string} token token

     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 25918,
                "number": "11969757068000",
                "buyer_name": "冯宇",
                "buyer_phone": "13588717651",
                "buyer_address": "长庆街青春坊16幢2单元301室",
                "pay_money": "119.00",
                "user_id": 19,
                "count": 1,
                "logistics_name": "",
                "express_no": "需要您输入快递号",
                "order_start_time": "0000-00-00 00:00:00",
                "buyer_summary": null,
                "seller_summary": "",
                "status": 8,
                "status_val": "待发货",
                "buyer_province": "浙江",
                "buyer_city": "杭州市",
                "buyer_county": "下城区",
                "buyer_township": ""
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function order(Request $request)
    {
        $order_id = $request->input('order_id');
        $user_id = $this->auth_user_id;
        if(!empty($order_id)){
            $orders = OrderModel::where('user_id' , $user_id)->where('id' , $order_id)->first();
            if($orders){
                $orderSku = $orders->orderSkuRelation;
            }
            if(!empty($orderSku)){
                $order_sku = $orderSku->toArray();
                foreach ($order_sku as $v){
                    $sku_id = $v['sku_id'];
                    $sku = ProductsSkuModel::where('id' , (int)$sku_id)->first();
                    if($sku->assets){
                        $sku->path = $sku->assets->file->small;
                    }else{
                        $sku->path = url('images/default/erp_product.png');
                    }
                    $order_sku[0]['path'] = $sku->path;
                    $order_sku[0]['product_title'] = $sku->product ? $sku->product->title : '';

                    $orders->order_skus = $order_sku;
                }
            }
        }else{
            return $this->response->array(ApiHelper::error('订单id不能为空', 200));
        }
        return $this->response->item($orders, new OrderTransformer())->setMeta(ApiHelper::meta());

    }
}
