<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\CategoryTransformer;
use App\Http\DealerTransformers\CityTransformer;
use App\Http\DealerTransformers\OrderListTransformer;
use App\Http\DealerTransformers\OrderTransformer;
use App\Jobs\SendReminderEmail;
use App\Models\AddressModel;
use App\Models\AssetsModel;
use App\Models\AuditingModel;
use App\Models\ChinaCityModel;
use App\Models\CountersModel;
use App\Models\DistributorModel;
use App\Models\HistoryInvoiceModel;
use App\Models\InvoiceModel;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController{

    /**
     * @api {get} /DealerApi/orders 订单列表
     * @apiVersion 1.0.0
     * @apiName Order orders
     * @apiGroup Order
     *
     * @apiParam {integer} status 状态: 0.全部； -1.取消(过期)；1.待付款； 5.待审核；6.待财务审核 8.待发货；10.已发货；20.完成
     * @apiParam {string} token token
     * @apiParam {integer} types 0.全部 1.当月
     * @apiSuccessExample 成功响应:
     *  {
     * "data": [
     * {
     *  "id": 25918,
     *  "is_voucher": 0 没有上传银行凭证 1.有上传,
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
     * "sku_name": "黑色-小风扇",                     // sku name
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
        $types = (int)$request->input('types', 0);
        $BeginDates=date('Y-m-01 00:00:00', strtotime(date("Y-m-d")));
        $now = date("Y-m-d 23:59:59",time());
        $status = (int)$request->input('status', 0);
        $per_page = (int)$request->input('per_page', 10);
        $user_id = $this->auth_user_id;
        $query = array();
        if($user_id == 0){
            return $this->response->array(ApiHelper::error('请先登录', 404));
        }else{
            $query['user_id'] = $user_id;
        }

        if ($types == 1) {//当月订单
            if($status != 0) {
                if ($status === -1) {
                    $orders = OrderModel::orderBy('id', 'desc')->where('status',0)->where('user_id',$user_id)->where('type',8)->whereBetween('order.order_start_time',[$BeginDates,$now])->paginate($per_page);
                }
                if ($status == 1) {
                    $where['is_voucher'] = 1;
                    $where['status'] = 5;
                    $orders = OrderModel::orderBy('id', 'desc')->where('status',1) ->orWhere($where)->where('user_id',$user_id)->where('type',8)->whereBetween('order.order_start_time',[$BeginDates,$now])->paginate($per_page);
                    }
                if ($status == 10){
                    $orders = OrderModel::orderBy('id', 'desc')->whereIn('status',[5,6,8,10])->where('is_voucher',0)->where('user_id',$user_id)->where('type',8)->whereBetween('order.order_start_time',[$BeginDates,$now])->paginate($per_page);
                }
                if ($status == 20){
                    $query['status'] = $status;
                    $orders = OrderModel::orderBy('id', 'desc')->where($query)->where('type',8)->whereBetween('order.order_start_time',[$BeginDates,$now])->paginate($per_page);
                }
            }else{
                $orders = OrderModel::orderBy('id', 'desc')->where('type',8)->where('user_id',$user_id)->whereBetween('order.order_start_time',[$BeginDates,$now])->paginate($per_page);
            }

        }else{//全部订单
            if ($status != 0){
                if ($status === -1) {
                    $orders = OrderModel::orderBy('id', 'desc')->where('status',0)->where('user_id',$user_id)->where('type',8)->paginate($per_page);
                }
                if ($status == 1) {
                    $where['is_voucher'] = 1;
                    $where['status'] = 5;
                    $orders = OrderModel::orderBy('id', 'desc')->where('status',1) ->orWhere($where)->where('user_id',$user_id)->where('type',8)->paginate($per_page);
                }
                if ($status == 10){
                    $orders = OrderModel::orderBy('id', 'desc')->whereIn('status',[5,6,8,10])->where('is_voucher',0)->where('user_id',$user_id)->where('type',8)->paginate($per_page);
                }
                if ($status == 20) {
                    $query['status'] = $status;
                    $orders = OrderModel::orderBy('id', 'desc')->where('type',8)->where($query)->paginate($per_page);
                }
            }else{
                $orders = OrderModel::orderBy('id', 'desc')->where('type',8)->where('user_id' , $user_id)->paginate($per_page);
            }
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
     *  "is_voucher": 0 没有上传银行凭证 1.有上传
     *  "number": "11969757068000",  //订单编号
     *  "pay_money": "119.00",   //应付总金额
     *  "total_money": "299.00",    //商品总金额
     *  "count": 1,                 //商品总数量
     *  "user_id": 19,             //用户id
     *  "express_id": 3,        // 物流id
     *  "express": 圆通快递,        //快递名称
     *  "express_no": 536728987,     //快递单号
     *  "order_start_time": "0000-00-00 00:00:00", //下单时间
     *  "status": 8,
     *  "status_val": "待发货",                //状态   2.上传凭证待审核
     *  "receiving_id": "1",          //发票类型(0.不开 1.普通 2.专票)
     *  "company_name": "北京太火红鸟科技有限公司",          //发票抬头
     *  "invoice_value": "1453",        //发票金额
     *  "over_time": "2018-09-11 00:00:00",  //订单过期时间
     *
     *
     *   "address": "三亚市天涯海角",
     *   "province": 陕西,
     *   "city": 汉中,
     *   "county": 勉县,
     *   "town": 0,
     *   "name": "小蜜蜂",
     *   "phone": "17802998888",
     *   "is_default": 0,
     *   "status": 1,
     *   "created_at": "2018-09-03 19:22:48",
     *   "updated_at": "2018-09-04 15:53:10",
     *   "deleted_at": null,
     *   "fixed_telephone": null
     *   "orderSkus": [
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
        if (!empty($order_id)) {
            $orders = OrderModel::where('user_id', $user_id)->where('id', $order_id)->first();
            if ($orders) {
                $orderSku = $orders->orderSkuRelation;//订单详情表
                $address = $orders->address;//地址表
                $invoice = HistoryInvoiceModel::where('order_id', $order_id)->where('difference', 0)->first();//发票历史表状态为0的
                $order_start_time = $orders->order_start_time;
                $order_timer = strtotime($order_start_time) + 60 * 60 * 24;
                $orders->over_time = date("Y-m-d H:i:s", $order_timer);//取消时间

                if ($invoice) {
                    $orders->receiving_id = $invoice->receiving_id;//发票类型(0.不开 1.普通 2.专票)
                    $orders->company_name = $invoice->company_name;//发票抬头
                    $orders->invoice_value = $invoice->invoice_value;//发票金额就是支付金额
                }

                $province = ChinaCityModel::where('oid', $orders->buyer_province)->select('name')->first();
                $city = ChinaCityModel::where('oid', $orders->buyer_city)->select('name')->first();
                $county = ChinaCityModel::where('oid', $orders->buyer_county)->select('name')->first();
                $town = ChinaCityModel::where('oid', $orders->buyer_township)->select('name')->first();
                if ($province) {
                    $orders->province = $province->name;
                }
                if ($city) {
                    $orders->city = $city->name;
                }
                if ($county) {
                    $orders->county = $county->name;
                }
                if ($town) {
                    $orders->town = $town->name;
                }
            }
            if (!empty($orderSku)) {
                $order_sku = $orderSku->toArray();
                foreach ($order_sku as $k => $v) {
                    $sku_id = $v['sku_id'];
                    $sku = ProductsSkuModel::where('id', (int)$sku_id)->first();

                    if ($sku->assets) {
                        $sku->path = $sku->assets->file->small;
                    } else {
                        $sku->path = url('images/default/erp_product.png');
                    }
                    $order_sku[$k]['path'] = $sku->path;
                    $order_sku[$k]['product_title'] = $sku->product ? $sku->product->title : '';
                    $orders->order_skus = $order_sku;
                }
            }

        }else{
            return $this->response->array(ApiHelper::error('没有找到该笔订单', 404));
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
     * @apiParam {string} payment_type 付款方式：1.在线 4.月结；6.公司转账
     * @apiParam {string} invoice_id 发票id  0.不开发票
     * @apiParam {string} token token
     * @apiParam {string} sku_id_quantity sku_id和数量 [{"sku_id":"9","quantity":"15"}]
     * @apiParam {string} product_id  '2,1,4,9'
     *
     */
    public function store(Request $request)
    {
        $status = DistributorModel::where('user_id',$this->auth_user_id)->select('id','status','mode')->first();
        if ($status['status'] != 2) {
            return $this->response->array(ApiHelper::error('审核未通过暂时无法下单！', 403));
        }

        $product_id = explode(",",$request->input('product_id'));
        $payment_type = $request->input('payment_type');
//        $payment_type = 4;
//        $product_id = [4,3,2,16];
        if ($product_id){
            $products = ProductsModel::whereIn('id',$product_id)->get();
            foreach ($products as $v){

                if ($status->mode == 1 && $v->mode == 2 && $payment_type == 4){//非月结
                        return $this->response->array(ApiHelper::error($v->title.'不支持月结支付方式，请选择其他支付方式！', 403));
                }
            }
        }
        $all = $request->all();
        $sku_quantity = $all['sku_id_quantity'];

        $sku_id_quantity = json_decode($sku_quantity,true);
        $user_id = $this->auth_user_id;

        $total_money = 0;
        $count = 0;
        $num = 0;
        $sell_price = 0;
        $sku_price = [];
        $skus = new ProductsSkuModel();
        foreach ($sku_id_quantity as $skuData) {
            $sku_id = $skuData['sku_id'];
            $count = $skuData['quantity'];
            $quantity = ProductsSkuModel::where('id',$sku_id)->first();
            $quantitys = $quantity->count_num;
            if ($count > $quantitys){
                return $this->response->array(ApiHelper::error('sku库存不足！', 403));
            }

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
            $num += $skuData['quantity'];
            }else{
                return $this->response->array(ApiHelper::error('暂无优惠信息', 403));
            }
        }
        $invoice_id = $request->input('invoice_id',0);

        $all['order_start_time'] = date("Y-m-d H:i:s");
        $all['user_id'] = $user_id;
        $all['distributor_id'] = $status['id'];
        $all['payment_type'] = $request->input('payment_type');

        if ($all['payment_type'] == 4){
           $all['status'] = 5;//已付款待审核
            $all['payment_time'] = date("Y-m-d H:i:s");//支付时间
        }else{
           $all['status'] = 1;//待付款
            $all['payment_time'] = '';
        }
        $all['total_money'] = $total_money;
        $all['pay_money'] = $total_money;
        $all['count'] = $num;
        $all['type'] = 8;
        $all['from_type'] = 4;

        $all['user_id_sales'] = config('constant.D3IN_user_id_sales');
        $all['store_id'] = config('constant.D3IN_store_id');
//        $all['storage_id'] = config('constant.D3IN_storage_id');
        $number = CountersModel::get_number('DD');
        $all['number'] = $number;
        $all['voucher_id'] = 0;//凭证暂为0
        $all['address_id'] = $request->input('address_id');

        $address = AddressModel::where('id','=',$all['address_id'])->first();
        $all['buyer_name'] = $address->name;
        $all['buyer_phone'] = $address->phone;
        $all['buyer_address'] = $address->address;
        $all['buyer_province'] = $address->province_id;
        $all['buyer_city'] = $address->city_id;
        $all['buyer_county'] = $address->county_id;
        $all['buyer_township'] = $address->town_id;

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
//        $storage_sku = new StorageSkuCountModel();
        $sku_id_arr = [];
        $quantity_arr = [];
        foreach($sku_id_quantity as $key=>$val){

            $sku_id_arr[] = $val['sku_id'];
            $quantity_arr[] = $val['quantity'];
        }
//        if(!$storage_sku->isCount($all['storage_id'][0], $user->department,$sku_id_arr, $quantity_arr)){
//            return $this->response->array(ApiHelper::error('仓库/部门库存不足！', 403));
//        }

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
            $h_invoice = InvoiceModel::where('id','=',$all['invoice_id'])->first();

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

            if ($h_invoice) {
                $history_invoice = new HistoryInvoiceModel();
                $history_invoice->user_id = $this->auth_user_id;
                $history_invoice->order_id = $order_id;
                $history_invoice->invoice_id = $invoice_id;
                $history_invoice->receiving_id = $h_invoice->receiving_id;
                $history_invoice->company_name = $h_invoice->company_name;
                $history_invoice->invoice_value = $order->pay_money;//发票金额就是支付金额
                $history_invoice->application_time = $order->order_start_time;
                $history_invoice->duty_paragraph = $h_invoice->duty_paragraph;
                $history_invoice->unit_address = $h_invoice->unit_address;
                $history_invoice->prove_id = $h_invoice->prove_id;
                $history_invoice->company_phone = $h_invoice->company_phone;
                $history_invoice->opening_bank = $h_invoice->opening_bank;
                $history_invoice->bank_account = $h_invoice->bank_account;
                $history_invoice->unit_address = $h_invoice->unit_address;
                $history_invoice->receiving_address = $h_invoice->receiving_address;
                $history_invoice->receiving_name = $h_invoice->receiving_name;
                $history_invoice->receiving_phone = $h_invoice->receiving_phone;
                $history_invoice->receiving_type = 2;

                if (!$history_invoice->save()) {
                    return $this->response->array(ApiHelper::error('发票历史信息保存失败！', 500));
                }
            }

            if ($order->payment_type == 4) {
                //月结就直接默认成已付款占货
                if (!$productSku->increasePayCount($order_sku_model->sku_id, $order_sku_model->quantity)) {
                    return $this->response->array(ApiHelper::error('付款占货关联操作失败', 403));
                }
            }else{//订单未付款占货(假定为未付款然后占货)
                if (!$productSku->increaseReserveCount($order_sku_model->sku_id, $order_sku_model->quantity)) {
                    return $this->response->array(ApiHelper::error('未付款占货关联操作失败', 403));
                }
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

                if ($order->payment_type == 4) {
                    //月结就直接默认成已付款占货
                    if (!$productSku->increasePayCount($order_sku_model->sku_id, $order_sku_model->quantity)) {
                        return $this->response->array(ApiHelper::error('付款占货关联操作失败', 403));
                    }
                }else{//订单未付款占货(假定为未付款然后占货)
                    if (!$productSku->increaseReserveCount($order_sku_model->sku_id, $order_sku_model->quantity)) {
                        return $this->response->array(ApiHelper::error('未付款占货关联操作失败', 403));
                    }
                }
            }
            $h_invoice = InvoiceModel::where('id','=',$all['invoice_id'])->first();
            if ($h_invoice) {
                $history_invoice = new HistoryInvoiceModel();
                $history_invoice->user_id = $this->auth_user_id;
                $history_invoice->order_id = $order_id;
                $history_invoice->invoice_id = $invoice_id;
                $history_invoice->receiving_id = $h_invoice->receiving_id;
                $history_invoice->company_name = $h_invoice->company_name;
                $history_invoice->invoice_value = $order->pay_money;//发票金额就是支付金额
                $history_invoice->application_time = $order->order_start_time;
                $history_invoice->duty_paragraph = $h_invoice->duty_paragraph;
                $history_invoice->unit_address = $h_invoice->unit_address;
                $history_invoice->prove_id = $h_invoice->prove_id;
                $history_invoice->company_phone = $h_invoice->company_phone;
                $history_invoice->opening_bank = $h_invoice->opening_bank;
                $history_invoice->bank_account = $h_invoice->bank_account;
                $history_invoice->unit_address = $h_invoice->unit_address;
                $history_invoice->receiving_address = $h_invoice->receiving_address;
                $history_invoice->receiving_name = $h_invoice->receiving_name;
                $history_invoice->receiving_phone = $h_invoice->receiving_phone;
                $history_invoice->receiving_type = 2;

                if (!$history_invoice->save()) {
                    return $this->response->array(ApiHelper::error('发票历史信息保存失败！', 500));
                }
            }
        }

        $ids = AuditingModel::where('type',1)->select('user_id')->first();
        if ($ids){
            //发送审核短信通知
            $dataes = new AuditingModel();
            $dataes->datas(1);
        }

        if ($order->status == 1){
            Log::info("创建延迟队列1");
            $job = (new SendReminderEmail($order_id,$order))->delay(config('constant.D3IN_over_time'));//新建订单24小时未支付取消订单
            $this->dispatch($job);
            Log::info("创建延迟队列2");
        }
        return $this->response->array(ApiHelper::success('Success', 200, $order));
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

    /**
     * @api {post} /DealerApi/order/cancel 取消订单
     * @apiVersion 1.0.0
     * @apiName Order cancel
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

    public function cancel(Request $request)
    {
        $order_id = $request->input('order_id');
        $user_id = $this->auth_user_id;
        $order = OrderModel::where(['id' => $order_id ,'user_id' => $user_id , 'status' => 1])->first();
        if(!$order){
            return $this->response->array(ApiHelper::error('没有找到该笔订单！', 500));
        }else {
            $orders =DB::table('order')
                ->where('user_id','=',$this->auth_user_id)
                ->where('id','=',$order_id)
                ->update(['status'=> 0]);

            $orderSku = $order->orderSkuRelation;//订单详情表
            $order_sku = $orderSku->toArray();
            foreach ($order_sku as $k=>$v) {
                $sku_id = $v['sku_id'];
                $productSku = ProductsSkuModel::where('id' , $sku_id)->first();
                if (!$productSku->decreaseReserveCount($v['sku_id'], $v['quantity'])) {
                    return $this->response->array(ApiHelper::error('增加库存操作失败', 403));
                }
            }

            return $this->response->array(ApiHelper::success());
        }
    }


    /**
     * @api {post} /DealerApi/order/confirm 确认收货
     * @apiVersion 1.0.0
     * @apiName Order confirm
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

    public function confirm(Request $request)
    {
        $order_id = $request->input('order_id');
        $user_id = $this->auth_user_id;
        $order = OrderModel::where(['id' => $order_id,'user_id' => $user_id])->first();
        if(!$order){
            return $this->response->array(ApiHelper::error('没有找到该笔订单！', 500));
        }else {
            $orders =DB::table('order')
                ->where('user_id','=',$this->auth_user_id)
                ->where('status','=',10)
                ->where('id','=',$order_id)
                ->update(['status'=> 20]);
            if ($orders){
                return $this->response->array(ApiHelper::success());
            }
            return $this->response->array(ApiHelper::error('暂未发货还不可以收货！', 403));
        }
    }

    /**
     * @api {post} /DealerApi/order/pay_money 收银台
     * @apiVersion 1.0.0
     * @apiName Order pay_money
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

    public function pay_money(Request $request)
    {
        $order_id = $request->input('order_id');
        $user_id = $this->auth_user_id;
        $order = OrderModel::where(['id' => $order_id , 'user_id' => $user_id])->select('id','number','pay_money')->first();
        if(!$order){
            return $this->response->array(ApiHelper::error('没有找到该笔订单！', 500));
        }else {
            return $this->response->array(ApiHelper::success('Success', 200, $order));
        }
    }

    /**
     * @api {post} /DealerApi/order/upload_img 上传转账凭证
     * @apiVersion 1.0.0
     * @apiName Order upload_img
     * @apiGroup Order
     *
     * @apiParam {integer} payment_type 付款方式：6.公司转账
     * @apiParam {integer} voucher_id 银行凭证图片ID
     * @apiParam {integer} user_id 用户ID
     * @apiParam {integer} order_id 订单ID
     * @apiParam {string} token token
     * @apiParam {string} random  随机数
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */

    public function upload_img(Request $request)
    {
        $order_id = $request->input('order_id');
        $payment_type = $request->input('payment_type');
        $voucher_id = $request->input('voucher_id');
        $random = $request->input('random');
        $user_id = $this->auth_user_id;

        if (!$order_id && !$payment_type && !$voucher_id && !$random) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        $order = OrderModel::find($order_id);
//        if ($order->payment_type != "公司转账") {
//            return $this->response->array(ApiHelper::error('不是公司转账方式不需要上传凭证！', 403));
//        }
        if (!$order){
            return $this->response->array(ApiHelper::error('没有找到该笔订单！', 403));
        }else{

            $assets = AssetsModel::where('random',$random)->get();
            foreach ($assets as $asset){
                $asset->target_id = $order->id;
                $asset->type = 23;
                $res = $asset->save();
                if (!$res){
                    return $this->response->array(ApiHelper::error('上传图片失败，请重试！', 403));
                }
            }

            $time = date('Y-m-d H:i:s',time());
            $result = DB::table('order')
                ->where('user_id','=',$user_id)
                ->where('id','=',$order_id)
//                ->where('payment_type','=',6)
                ->update(['voucher_id'=>$voucher_id,'status'=>5,'is_voucher'=>1,'payment_time' => $time,'payment_type'=>6]);
            if (!$result){
                return $this->response->array(ApiHelper::error('修改订单状态失败！', 403));
            }

            return $this->response->array(ApiHelper::success('上传成功', 200));
        }

    }



    /**
     * @api {get} /DealerApi/order/search 订单搜索
     * @apiVersion 1.0.0
     * @apiName order search
     * @apiGroup order
     *
     * @apiParam {string} name 商品名称/订单号/收件人
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     *
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
     * "sku_name": "黑色-小风扇",                     // sku name
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
     */


    public function search(Request $request)
    {
        $this->per_page = $request->input('per_page', $this->per_page);
        $name = $request->input('name');
        if (!$name) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        $orders = new OrderModel();
        if (!empty($name)) {
//            $order_sku_relations = OrderSkuRelationModel::where('sku_name' ,'like','%'.$name.'%')->get();
//            $order_id = [];
//            foreach ($order_sku_relations as $v){
//                $order_id[] = $v->order_id;
//            }
            $order_sku = DB::table('order_sku_relation')
                ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->where('products.title', 'like', '%' . $name . '%')
                ->select('order_sku_relation.order_id as order_id')->groupBy('order.id')->get();
            $orderIdArr = [];
            foreach ($order_sku as $k => $val) {
                $orderIdArr[] = $val->order_id;
            }

            $orders = $orderIdArr ? $orders->whereIn('id', $orderIdArr) : $orders->where('number', 'like', '%' . $name . '%')->orWhere('buyer_name', 'like', '%' . $name . '%');

        }
        $orders=$orders->where('user_id', $this->auth_user_id);
        $orders = $orders->orderBy('id', 'desc')->paginate($this->per_page);
        if (count($orders) > 0) {
            return $this->response->paginator($orders, new OrderListTransformer())->setMeta(ApiHelper::meta());
        } else {
            return $this->response->array(ApiHelper::error('没有找到合适的订单', 404));
        }
    }
}