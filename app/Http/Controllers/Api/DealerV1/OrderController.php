<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\CategoryTransformer;
use App\Http\DealerTransformers\CityTransformer;
use App\Http\DealerTransformers\OrderTransformer;
use App\Models\ChinaCityModel;
use App\Models\CountersModel;
use App\Models\DistributorModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductSkuRelation;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\ReceiveOrderModel;
use App\Models\SkuRegionModel;
use App\Models\StorageSkuCountModel;
use App\Models\UserModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController{

    /**
     * @api {get} /DealerApi/order/city 省份列表
     * @apiVersion 1.0.0
     * @apiName Order cities
     * @apiGroup Order
     *
     * @apiParam {string} token token
     */
    public function city()
    {
        $china_city = ChinaCityModel::where('layer',1)->get();
        return $this->response()->collection($china_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /DealerApi/order/fetchCity 城市列表
     * @apiVersion 1.0.0
     * @apiName Order fetchCity
     * @apiGroup Order
     *
     * @apiParam {integer} oid 唯一（父id）
     * @apiParam {integer} layer 级别（子id）2
     * @apiParam {string} token token
     */
    public function fetchCity(Request $request)
    {
        $oid = (int)$request->input('value');
        $layer = (int)$request->input('layer');
        $chinaModel = new ChinaCityModel();
        $fetch_city = $chinaModel->fetchCity($oid,$layer);

        if ($layer == 1){
            $fetch_city = ChinaCityModel::where('layer',1)->where('oid',$oid)->first();
        }

        return $this->response()->collection($fetch_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /DealerApi/orders 订单列表
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
    "next": "http://www.work.com/DealerApi/orders?page=2"
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
     * @api {get} /DealerApi/order 订单详情
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


    /**
     * @api {post} /DealerApi/order/store 保存新建订单
     * @apiVersion 1.0.0
     * @apiName Order store
     * @apiGroup Order
     *
     * @apiParam {string} outside_target_id 站外订单号
     * @apiParam {string} buyer_name 收货人
     * @apiParam {string} buyer_tel 电话
     * @apiParam {string} buyer_phone 手机号
     * @apiParam {string} buyer_zip 邮编
     * @apiParam {string} buyer_address 收获地址
     * @apiParam {string} buyer_province 省
     * @apiParam {string} buyer_city 市
     * @apiParam {string} buyer_county 县
     * @apiParam {string} buyer_township 镇
     * @apiParam {string} buyer_summary 买家备注
     * @apiParam {string} seller_summary 卖家备注
     * @apiParam {string} payment_type 付款方式：4：月结；5：现结；
     * @apiParam {string} sku_id_quantity sku_id和数量 [{"sku_id":"9","quantity":"15"}]
     *
     *
     * @apiParam {string} token token
     */
    public function store(Request $request)
    {
        $status = DistributorModel::where('user_id',$this->auth_user_id)->select('status')->first();
        if ($status['status'] != 2) {
            return $this->response->array(ApiHelper::error('审核未通过暂时无法下单！', 403));
        }
        $all = $request->all();
        $sku_quantity = $all['sku_id_quantity'];

        $sku_id_quantity = json_decode($sku_quantity,true);
        $user_id = $this->auth_user_id;

        $total_money = 0;
        $count = 0;
        $sell_price = 0;
        $sku_price = [];
        foreach ($sku_id_quantity as $skuData) {
            $sku_id = $skuData['sku_id'];
            $count = $skuData['quantity'];
            $sku_region = SkuRegionModel::where('sku_id', $sku_id)->get();

            if (count($sku_region)>0) {

//            求最大值
            $max = 0;
            $prices = 0;
            foreach ($sku_region as $key => $val) {
                $max = max($max, $val['max']);
                $prices = $val['sell_price'];
            }
//            求最小值
            $mix = $sku_region[0]['min'];
            $price = $sku_region[0]['sell_price'];
            foreach ($sku_region as $key => $val) {
                if ($mix > $val['min']) {
                    $mix = $val['min'];
                    $price = $val['sell_price'];
                }
            }

            foreach ($sku_region as $k => $v) {
                if ($count >= $v['min'] && $count <= $v['max']) {
                    $sell_price = $v['sell_price'];
                }
            }
            if ($count < $mix) {//如果数量小于价格区间最小的 就按价格区间最小数量的价格算
                $sell_price = $price;
            }
            if ($count > $max) {//如果数量大于价格区间最大的 就按价格区间最大数量的价格算
                $sell_price = $prices;
            }
            $sku_price[$sku_id]=$sell_price;

            $total_money += sprintf("%.2f", $sell_price * $skuData['quantity']);
        }else{
                return $this->response->array(ApiHelper::error('暂无优惠信息', 403));
            }
        }

        $all['outside_target_id'] = $request->input('outside_target_id');
        $all['buyer_name'] = $request->input('buyer_name');
        $all['buyer_tel'] = $request->input('buyer_tel') ? $request->input('buyer_tel') : '';
        $all['buyer_phone'] = $request->input('buyer_phone');
        $all['buyer_zip'] = $request->input('buyer_zip') ? $request->input('buyer_zip') : '';
        $all['buyer_address'] = $request->input('buyer_address');
        $all['buyer_province'] = $request->input('buyer_province') ? $request->input('buyer_province') : '';
        $all['buyer_city'] = $request->input('buyer_city') ? $request->input('buyer_city') : '';
        $all['buyer_county'] = $request->input('buyer_county') ? $request->input('buyer_county') : '';
        $all['buyer_township'] = $request->input('buyer_township') ? $request->input('buyer_township') : '';
        $all['buyer_summary'] = $request->input('buyer_summary') ? $request->input('buyer_summary') : '' ;
        $all['seller_summary'] = $request->input('seller_summary') ? $request->input('seller_summary') : '';
        $all['order_start_time'] = date("Y-m-d H:i:s");
        $all['user_id'] = $user_id;
        $all['distributor_id'] = $this->auth_user_id;
        $all['status'] = 5;
        $all['total_money'] = $total_money;
        $all['pay_money'] = $total_money;
        $all['count'] = $count;
        $all['type'] = 8;
        $all['from_type'] = 4;
        $all['invoice_type'] = $request->input('invoice_type');
        $all['user_id_sales'] = config('constant.D3IN_user_id_sales');
        $all['store_id'] = config('constant.D3IN_store_id');
        $all['storage_id'] = config('constant.D3IN_storage_id');
        $number = CountersModel::get_number('DD');
        $all['number'] = $number;

        $rules = [
            'outside_target_id' => 'required|max:20',
            'buyer_name' => 'required|max:20',
            'buyer_phone' => 'required|max:20',
            'buyer_address' => 'required|max:200',
            'invoice_type' => 'required|max:20',
        ];

        $massage = [
            'outside_target_id.required' => '站外订单号不能为空',
            'outside_target_id.max' => '站外订单号不能超过20字',
            'buyer_name.required' => '收货人不能为空',
            'buyer_name.max' => '收货人不能超过20字符',
            'buyer_phone.required' => '收货人电话不能为空',
            'buyer_phone.max' => '收货人不能超过20字符',
            'buyer_address.required' => '收货人地址不能为空',
            'buyer_address.max' => '收货人地址不能超过200字符',
            'invoice_type.required' => '发票类型不能为空',
            'invoice_type.max' => '发票类型不能不能超过20字符',
        ];

        $validator = Validator::make($all, $rules, $massage);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        $user = UserModel::find($all['user_id_sales']);
        $storage_sku = new StorageSkuCountModel();
        $sku_id_arr = [];
        $quantity_arr = [];
        foreach($sku_id_quantity as $key=>$val){

            $sku_id_arr[] = $val['sku_id'];
            $quantity_arr[] = $val['quantity'];
        }
        if(!$storage_sku->isCount($all['storage_id'][0], $user->department,$sku_id_arr, $quantity_arr)){
            return ajax_json(0,'仓库/部门库存不足');
        }


        $order = OrderModel::create($all);
        if(!$order) {
            return $this->response->array(ApiHelper::error('创建订单失败！', 500));
        }
        $order_id = $order->id;
        //保存订单详情
        if(count($sku_id_quantity) == count($sku_id_quantity , 1) ) {
            $sku_id = $sku_id_quantity['sku_id'];

            $productSku = ProductsSkuModel::where('id' , $sku_id)->first();
            $product = ProductsModel::where('id',$productSku->product_id)->first();


            $order_sku_model = new OrderSkuRelationModel();
            $order_sku_model->order_id = $order_id;
            $order_sku_model->sku_id = $sku_id;
            $order_sku_model->product_id = $productSku->product_id;
            $product_title = $product->title;
            $order_sku_model->sku_number = $productSku['number'];
            $order_sku_model->price =$sku_price[$sku_id];
            $order_sku_model->sku_name = $product_title.'---'.$productSku['mode'];
            $order_sku_model->quantity = $sku_id_quantity['quantity'];
            if(!$order_sku_model->save()){
                return $this->response->array(ApiHelper::error('订单详情保存失败！', 500));
            }
            //订单付款占货(无论现结还是月结下单后都要假定为已付款然后占货)
            if(!$productSku->increasePayCount($order_sku_model->sku_id,$order_sku_model->quantity)){
                return ajax_json(0,'付款占货关联操作失败');
            }

        }else {
            foreach ($sku_id_quantity as $v){
                $sku_id = $v['sku_id'];
                $productSku = ProductsSkuModel::where('id' , $sku_id)->first();
                $product = ProductsModel::where('id' , $productSku->product_id)->first();

                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_id = $sku_id;
                $order_sku_model->product_id = $productSku->product_id;
                $product_title = $product->title;
                $order_sku_model->sku_number = $productSku['number'];
                $order_sku_model->price = $sku_price[$sku_id];
                $order_sku_model->sku_name = $product_title.'---'.$productSku['mode'];
                $order_sku_model->quantity = $v['quantity'];
                if(!$order_sku_model->save()){
                    return $this->response->array(ApiHelper::error('订单详情保存失败！', 500));
                }
                //订单付款占货(无论现结还是月结下单后都要假定为已付款然后占货)
                if(!$productSku->increasePayCount($sku_id,$v['quantity'])){
                    return ajax_json(0,'付款占货关联操作失败');
                }
            }

        }
        // 创建订单收款单
        $model = new ReceiveOrderModel();
        if (!$model->orderCreateReceiveOrder($order_id)) {
            return ajax_json(0,"ID:'. $order_id .'订单发货创建订单收款单错误");
        }

        return $this->response->array(ApiHelper::success());
    }


    /**
     * @api {post} /DealerApi/order/destroy 订单删除
     * @apiVersion 1.0.0
     * @apiName Order destroy
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
     */

    public function destroy(Request $request)
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