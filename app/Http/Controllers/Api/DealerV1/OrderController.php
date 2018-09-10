<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\CategoryTransformer;
use App\Http\DealerTransformers\CityTransformer;
use App\Http\DealerTransformers\OrderListTransformer;
use App\Http\DealerTransformers\OrderTransformer;
use App\Models\AssetsModel;
use App\Models\AuditingModel;
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
     * @api {get} /DealerApi/orders 订单列表
     * @apiVersion 1.0.0
     * @apiName Order orders
     * @apiGroup Order
     *
     * @apiParam {integer} status 状态: 0.全部； -1.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
     *  {
     * "data": [
     * {
     *  "id": 25918,
     *   "number": "11969757068000",       //订单编号
     *  "buyer_name": "冯宇",               //收货人
     *  "pay_money": "119.00",              //支付总金额
     *  "user_id": 19,
     * "order_start_time": "0000-00-00 00:00:00", //下单时间
     * "status": 8,
     * "status_val": "待发货",                 //订单状态
     * "payment_type": "在线支付"               //支付方式
     * "total_money": "299.00",             //商品总金额
     * "count": 1,                            //商品总数量
     * "sku_relation": [
     * {
     * "sku_id": 42,
     * "price":   单价
     * "product_title": "小风扇",                   //商品名称
     * "quantity": 1,                      //订单明细数量
     * "sku_mode": "黑色",                     // 颜色/型号
     * "image": "http://www.work.com/images/default/erp_product1.png",   //sku图片
     * }
     * ],
     *  "meta": {
     *  "message": "Success.",
     *  "status_code": 200,
     *  "pagination": {
     *  "total": 717,
     *  "count": 2,
     *  "per_page": 2,
     *  "current_page": 1,
     *  "total_pages": 359,
     *  "links": {
     *  "next": "http://www.work.com/DealerApi/orders?page=2"
     *  }
     *  }
     *  }
     *   }
     *
     */
    public function orders(Request $request)
    {
        $status = (int)$request->input('status', 0);
        $per_page = (int)$request->input('per_page', 10);
        $user_id = $this->auth_user_id;
        $query = array();
        if($user_id == 0){
            return $this->response->array(ApiHelper::error('请先登录', 404));
        }else{
            $query['user_id'] = $user_id;
        }
        if(!empty($status)){
            if ($status === -1) {
                $status = 0;
            }
            $query['status'] = $status;
            $orders = OrderModel::where($query)->where('type',8)->orderBy('id', 'desc')->paginate($per_page);
        }else{
            $orders = OrderModel::orderBy('id', 'desc')->where('type',8)->where('user_id' , $user_id)->paginate($per_page);
        }
        return $this->response->paginator($orders, new OrderListTransformer())->setMeta(ApiHelper::meta());

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
     * {
     *  "data": {
     *  "id": 25918,
     *  "number": "11969757068000",  //订单编号
     *  "pay_money": "119.00",   //应付总金额
     *  "total_money": "299.00",    //商品总金额
     *  "count": 1,                 //商品总数量
     *  "user_id": 19,             //用户id
     *  "express_id": 3,        // 物流id
     *  "express": 圆通快递,        //快递名称
     *  "express_no": 536728987,     //快递单号
     *  "order_start_time": "0000-00-00 00:00:00", //发货时间
     *  "status": 8,
     *  "status_val": "待发货",
     *  "receiving_id": "111",          //发票类型
     *  "company_name": "1",          //发票抬头
     *  "invoice_value": "1453",        //发票金额
     *  "over_time": "0000-00-00 00:00:00",  //过期时间
     *
     *  "address_list":[
     *  "id":1,
     *  "name": "shusyh"                 //收件人
     *  "province_id":1         省份oid
     *  "city_id":2             城市oid
     *  "county_id":3           区/县oid
     *  "town_id":4             城镇/乡oid
     *  "province":1         省份
     *  "city":2             城市
     *  "county":3           区/县
     *  "town":4             城镇/乡
     *  "address":798艺术广场     详细地址
     * "phone"：13432522222     电话
     * ]
     * "orderSkus": [
     * {
     * "sku_id": 42,
     * "price":   单价
     * "product_title": "小风扇",                   //商品名称
     * "quantity": 1,                      //订单明细数量
     * "sku_mode": "黑色",                     // 颜色/型号
     * "image": "http://www.work.com/images/default/erp_product1.png",   //sku图片
     * }
     * ]
     *  },
     * "meta": {
     *  "message": "Success.",
     * "status_code": 200
     * }
     * }
     */
    public function order(Request $request)
    {
        $order_id = $request->input('order_id');
        $user_id = $this->auth_user_id;
        if(!empty($order_id)){
            $orders = OrderModel::where('user_id' , $user_id)->where('id' , $order_id)->first();
            if($orders){
                $orderSku = $orders->orderSkuRelation;//订单详情表
                $address = $orders->address;//地址表
                $invoice = HistoryInvoiceModel::where('order_id',$orders->id)->where('difference',0)->first();//发票历史表状态为0的
                $order_start_time =$orders->order_start_time;
                $order_timer = strtotime($order_start_time)+ 60*60*24;
                $orders->over_time = date("Y-m-d H:i:s",$order_timer);//取消时间
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
            if (!empty($address)){
                $orders->address_list = $address;
            }
            if (!empty($invoice)){
                $orders->receiving_id = $invoice->receiving_id;//发票类型
                $orders->company_name = $invoice->company_name;//发票抬头
                $orders->invoice_value = $invoice->invoice_value;//发票金额
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
     * @apiParam {integer} address_id 收获地址ID
     * @apiParam {string} payment_type 付款方式：4：月结；5：现结；
     * @apiParam {string} invoice_id 发票id
     * @apiParam {string} token token
     * @apiParam {string} sku_id_quantity sku_id和数量 [{"sku_id":"9","quantity":"15"}]
     *
     *
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

        $all['address_id'] = $request->input('address_id');
        $all['order_start_time'] = date("Y-m-d H:i:s");
        $all['user_id'] = $user_id;
        $all['distributor_id'] = $this->auth_user_id;
//        $all['status'] = 5;
        $all['status'] = 1;//待付款
        $all['total_money'] = $total_money;
        $all['pay_money'] = $total_money;
        $all['count'] = $count;
        $all['type'] = 8;
        $all['from_type'] = 4;
        $all['invoice_id'] = $request->input('invoice_id');
        $all['user_id_sales'] = config('constant.D3IN_user_id_sales');
        $all['store_id'] = config('constant.D3IN_store_id');
        $all['storage_id'] = config('constant.D3IN_storage_id');
        $number = CountersModel::get_number('DD');
        $all['number'] = $number;

        $rules = [
            'address_id' => 'required|integer',
            'invoice_id' => 'required|integer',
        ];

        $massage = [
            'address_id.required' => '收货id不能为空',
            'address_id.address_id' => '收货id格式不对',
            'invoice_id.required' => '发票id不能为空',
            'invoice_id.invoice_id' => '发票id格式不对',
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
            //订单未付款占货(假定为未付款然后占货)
            if(!$productSku->increaseReserveCount($order_sku_model->sku_id,$order_sku_model->quantity)){
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
                //订单未付款占货(假定为未付款然后占货)
                if(!$productSku->increaseReserveCount($sku_id,$v['quantity'])){
                    return ajax_json(0,'付款占货关联操作失败');
                }
            }

        }
        // 创建订单收款单
        $model = new ReceiveOrderModel();
        if (!$model->orderCreateReceiveOrder($order_id)) {
            return ajax_json(0,"ID:'. $order_id .'订单发货创建订单收款单错误");
        }
        //发送审核短信通知
        $dataes = new AuditingModel();
        $dataes->datas(1);

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