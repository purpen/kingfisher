<?php
namespace App\Http\Controllers\Api\SaasV1;


use App\Http\ApiHelper;
use App\Http\SaasTransformers\OrderTransformer;
use App\Jobs\SendExcelOrder;
use App\Models\CountersModel;
use App\Models\FileRecordsModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductSkuRelation;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\ProductUserRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


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
            if (!in_array($excel_type, [1, 2, 3])) {
                return $this->response->array(ApiHelper::error('请选择订单类型', 400));
            }
            if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
                return $this->response->array(ApiHelper::error('上传失败', 400));
            }
            $file = $request->file('file');
            //文件记录表保存
            $fileName = $file->getClientOriginalName();
            $file_type = explode('.', $fileName);
            $mime = $file_type[1];
            if(!in_array($mime , ["csv" , "xlsx"])){
                return $this->response->array(ApiHelper::error('请选择正确的文件格式', 400));

            }

            $fileSize = $file->getClientSize();
            $file_records = new FileRecordsModel();
            $file_records['user_id'] = $user_id;
            $file_records['status'] = 0;
            $file_records['file_name'] = $fileName;
            $file_records['file_size'] = $fileSize;
            $file_records->save();
            $file_records_id = $file_records->id;

            $accessKey = config('qiniu.access_key');
            $secretKey = config('qiniu.secret_key');
            $auth = new Auth($accessKey, $secretKey);

            $bucket = config('qiniu.material_bucket_name');

            $token = $auth->uploadToken($bucket);
            $filePath = $file->getRealPath();
            $key = 'orderExcel/' . date("Ymd") . '/' . uniqid();
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 put 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
            //七牛的回掉地址
            $data = config('qiniu.material_url') . $key;
            //进行队列处理
            $this->dispatch(new SendExcelOrder($data, $user_id, $excel_type, $mime, $file_records_id));
        return $this->response->array(ApiHelper::success('导入成功' , 200));

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


    /**
     * @api {post} /saasApi/order/store 保存订单
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
     * @apiParam {string} sku_id_quantity sku_id和数量 (sku_id,quantity)
     *
     *
     * @apiParam {string} token token
     */
    public function store(Request $request)
    {
        $all = $request->all();
        $sku_quantity = $request->input('sku_id_quantity');
        $sku_id_quantity = json_decode($sku_quantity,true);
        $user_id = $this->auth_user_id;
        $total_money = 0.00;
        $count = 0;
        //一维数组走上面，多维数组走下面
        if(count($sku_id_quantity) == count($sku_id_quantity , 1) ){
            $sku_id = $sku_id_quantity['sku_id'];
            $order_product_sku = new ProductSkuRelation();
            $product_sku = $order_product_sku->skuInfo($user_id , $sku_id);
            $total_money = $sku_id_quantity['quantity'] * $product_sku['price'];
            $count = $sku_id_quantity['quantity'];

        }else{
            foreach ($sku_id_quantity as $v){
                $sku_id = $v['sku_id'];
                $order_product_sku = new ProductSkuRelation();
                $product_sku = $order_product_sku->skuInfo($user_id , $sku_id);
                $total_money += $v['quantity'] * $product_sku['price'];
                $count += $v['quantity'];
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
        $all['status'] = 5;
        $all['total_money'] = $total_money;
        $all['pay_money'] = $total_money;
        $all['count'] = $count;

        $number = CountersModel::get_number('DD');
        $all['number'] = $number;


        $rules = [
            'outside_target_id' => 'required|max:20',
            'buyer_name' => 'required|max:20',
            'buyer_phone' => 'required|max:20',
            'buyer_address' => 'required|max:200',
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
        ];

        $validator = Validator::make($all, $rules, $massage);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        $order = OrderModel::create($all);
        if(!$order) {
            return $this->response->array(ApiHelper::error('创建订单失败！', 500));
        }
        $order_id = $order->id;
        //保存订单详情
        if(count($sku_id_quantity) == count($sku_id_quantity , 1) ){
            $sku_id = $sku_id_quantity['sku_id'];
            $order_product_sku = new ProductSkuRelation();
            $product_sku = $order_product_sku->skuInfo($user_id , $sku_id);
            $order_sku_model = new OrderSkuRelationModel();
            $order_sku_model->order_id = $order_id;
            $order_sku_model->sku_id = $sku_id;
            $productSku = ProductsSkuModel::where('id' , $sku_id)->first();
            $order_sku_model->product_id = $productSku->product_id;
            $product = ProductsModel::where('id' , $productSku->product_id)->first();
            $product_title = $product->title;
            $order_sku_model->sku_number = $product_sku['number'];
            $order_sku_model->price = $product_sku['price'];
            $order_sku_model->sku_name = $product_title.'---'.$product_sku['mode'];
            $order_sku_model->quantity = $sku_id_quantity['quantity'];
            if(!$order_sku_model->save()){
                return $this->response->array(ApiHelper::error('订单详情保存失败！', 500));
            }

        }else{
            foreach ($sku_id_quantity as $v){
                $sku_id = $v['sku_id'];
                $order_product_sku = new ProductSkuRelation();
                $product_sku = $order_product_sku->skuInfo($user_id , $sku_id);
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_id = $sku_id;
                $productSku = ProductsSkuModel::where('id' , $sku_id)->first();
                $order_sku_model->product_id = $productSku->product_id;
                $product = ProductsModel::where('id' , $productSku->product_id)->first();
                $product_title = $product->title;
                $order_sku_model->sku_number = $product_sku['number'];
                $order_sku_model->price = $product_sku['price'];
                $order_sku_model->sku_name = $product_title.'---'.$product_sku['mode'];
                $order_sku_model->quantity = $v['quantity'];
                if(!$order_sku_model->save()){
                    return $this->response->array(ApiHelper::error('订单详情保存失败！', 500));
                }
            }

        }
        return $this->response->array(ApiHelper::success());

    }

     /**
      * @api {post} /saasApi/order/destroy 订单删除
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
