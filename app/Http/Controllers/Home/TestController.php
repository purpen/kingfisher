<?php

namespace App\Http\Controllers\Home;

use App\Helper\ShopApi;
use App\Models\CountersModel;
use App\Models\FileRecordsModel;
use App\Models\LogisticsModel;
use App\Models\Membership;
use App\Models\OrderModel;
use App\Models\OrderMould;
use App\Models\OrderSkuRelationModel;
use App\Models\OrderUserModel;
use App\Models\ProductSkuRelation;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\ProductUserRelation;
use App\Models\ReceiveOrderModel;
use App\Models\RefundMoneyOrderModel;
use App\Models\StoreModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class TestController extends Controller
{
    //分发saas 用户关联sku user_id 修复
    public function saasSku()
    {
        $pros = ProductUserRelation::get();
        foreach ($pros as $pro){
            $skus = $pro->ProductSkuRelation;
            foreach($skus as $sku){
                $sku->user_id = $pro->user_id;
                $sku->save();
            }
        }

        echo "分发saas 用户关联sku user_id 修复完成";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jdCalllback(Request $request)
    {
        Log::write('info', 'Test jd_callback!!!!');
        Log::write('info', json_encode($request->input()));
        echo "123";
        //return view('home.index');
    }


    //通过商品和商品sku 通过number，建立已product_id 关联,脚本
    public function productAndSku(){
        $productSkus = ProductsSkuModel::where('id','>','1740')->get();
        foreach ($productSkus as $productSku){
            $product_number = $productSku->product_number;
            $id = ProductsModel::where('number',$product_number)->first()->id;
//            dd($id);
            $productSku->product_id = $id;
            $productSku->save();
        }
        return "okokok";
    }

    //通过商品和供应商名称 通过，建立已supplier_id 关联,脚本
    public function productAndSupplier(){
        $products = ProductsModel::where('id','>',1137)->get();
        foreach ($products as $product) {
            $name = $product->supplier_name;
            $id = SupplierModel::where('nam',$name)->first();
            if(!$id){
                continue;
            }
            $id = $id->id;
            $product->supplier_id = $id;
            $product->save();
        }
        return 'okokok';
    }



//    public function ceShi()
//    {
//        $suppliers=DB::table('supplier')->get();
//        foreach($suppliers as $supplier){
////            $number = DB::table('products')->where('number',$product->number)->count();
////            if($number>0){
////                continue;
////            }
//            DB::table('suppliers')->insert(
//                [
//                    'name'=>$supplier->name,
//                    'nam'=>$supplier->nam,
//                    'summary'=>$supplier->summary,
//                    'contact_user'=>$supplier->contact_user,
//                    'contact_number'=>$supplier->contact_number,
//                    'tel'=>$supplier->tel,
//                    'address'=>$supplier->address,
//                    'contact_qq'=>$supplier->contact_qq,
//                    'summary'=>$supplier->summary
//
//                ]);
//        }
//
//    }
    public function ceShi()
    {
        $products_sku=DB::table('sku')->get();
        foreach($products_sku as $product_sku){
            $number = DB::table('products_sku')->where('number',$product_sku->B)->count();
            if($number>0){
                continue;
            }
            if($product_sku->B == null)
            {
                continue;
            }

            DB::table('products_sku')->insert(
                [
//                    'name'=>$supplier->name,
//                    'nam'=>$supplier->nam,
//                    'summary'=>$supplier->summary,
//                    'contact_user'=>$supplier->contact_user,
//                    'contact_number'=>$supplier->contact_number,
//                    'tel'=>$supplier->tel,
//                    'address'=>$supplier->address,
//                    'contact_qq'=>$supplier->contact_qq,

                    'number'=>$product_sku->B,

                    'product_number'=>$product_sku->A,


                    'mode'=>$product_sku->C,
//                    'title'=>$product->title,
//                    'tit'=>$product->tit,
//                    'supplier_name'=>$product->supplier_name,
                    'bid_price'=>$product_sku->D,
                    'cost_price'=>$product_sku->E,
                    'price'=>$product_sku->F
                ]);

        }

    }

    //手动运行订单，退款定时任务
    public function timingTask(){
        $jdStore = StoreModel::where('platform',2)->get();
        foreach($jdStore as $store){
            $order = new OrderModel();
            dd($order->saveOrderList($store->access_token,$store->id));

            //$refund = new RefundMoneyOrderModel();
            //$refund->saveRefundList($store->access_token,$store->id);
        }
//        $orderModel = new OrderModel();
//        $orderModel->autoChangeStatus();
//        $orderModel->saveShopOrderList();
    }

    public function shopOrderTest()
    {
        $shopApi = new ShopApi();
        $data = $shopApi->pullOrder(1);
//        $data = $shopApi->send_goods(1, [],[]);
        dd($data);
    }

    public function suppliers()
    {
        $suppliers = SupplierModel::get();
        foreach ($suppliers as $supplier){
            $supplier->random_id = str_random(6);
            $supplier->save();
        }
        return 666;
    }

    public function memberships()
    {
        $memberships = OrderUserModel::get();
        foreach ($memberships as $membership){
            $membership->random_id = uniqid();
            $membership->save();
        }
        return 666;
    }

//    public function testUpload()
//    {
//        $accessKey = config('qiniu.access_key');
//        $secretKey = config('qiniu.secret_key');
//        $auth = new Auth($accessKey, $secretKey);
//
//        $bucket = config('qiniu.material_bucket_name');
//
//        $token = $auth->uploadToken($bucket);
//        //获取文件
////        $file = $request->file('image');
//        //获取文件路径
////        $filePath = $file->getRealPath();
//        $filePath = file_get_contents("http://mmbiz.qpic.cn/mmbiz_png/TWTeiaAEGYyibTShTIvAia3B1JfudmGKVzDff1snqyE86CpAJ21jh7pIKMTmTJs0AkhFDDhmkMtoFDUNFDw6HMm8Q/0?wx_fmt=png");
////        $fileurl = url('http://orrrmkk87.bkt.clouddn.com/article/1500604440/59716818364c5');
//        // 上传到七牛后保存的文件名
////        $content = file_get_contents($url);
////        $filePath = file_put_contents('qwe', $content);
////        dd($filePath);
//        $date = time();
//        $key = 'article/'.$date.'/'.uniqid();
//        // 初始化 UploadManager 对象并进行文件的上传。
//        $uploadMgr = new UploadManager();
//        // 调用 UploadManager 的 putFile 方法进行文件的上传。
//        list($ret, $err) = $uploadMgr->put($token, $key, $filePath);
//        $data = array(
//            'status'=> 0,
//            'message'=> 'ok',
//            'url'=> config('qiniu.material_url').$key
//        );
//        return $data['url'];
//    }


    public function orderExcel()
    {
        return view('orderExcel');
    }

    public function user_id_sales()
    {
        $user_id_sales = config('constant.user_id_sales');
        $orders = OrderModel::where('user_id_sales' , 0)->where('type' , 5)->get();
        foreach ($orders as $order)
        {
            $order->user_id_sales = $user_id_sales;
            $order->save();
        }
        return 6666;
    }

    public function excel(Request $request)
    {
        if(!$request->hasFile('file') || !$request->file('file')->isValid()){
            return '上传失败';
        }
        $file = $request->file('file');
        $id = $request->input('id');
//        $user_id = $this->auth_user_id;
        $user_id = 1;
        //文件记录表保存
        $fileName = $file->getClientOriginalName();
        $file_type = explode('.', $fileName);
        $mime = $file_type[1];
        if(!in_array($mime , ["csv" , "xlsx"])){
//            return $this->response->array(ApiHelper::error('请选择正确的文件格式', 400));

        }
//        $name = uniqid();
//        $newFile = config('app.tmp_path').$name.'.'.$mime;

        $fileSize = $file->getClientSize();
        $file_records = new FileRecordsModel();
        $file_records['user_id'] = $user_id;
        $file_records['status'] = 0;
        $file_records['file_name'] = $fileName;
        $file_records['file_size'] = $fileSize;
        $file_records->save();
        $file_records_id = $file_records->id;


        $orderMould = OrderMould::where('id' , $id)->first();
        $outside_target_id = $orderMould->outside_target_id;
        $sku_number = $orderMould->sku_number;
        $buyer_name = $orderMould->buyer_name;
        $buyer_phone = $orderMould->buyer_phone;
        $buyer_address = $orderMould->buyer_address;
        $order_start_time = $orderMould->order_start_time;
        $summary = $orderMould->summary;
        $buyer_summary = $orderMould->buyer_summary;
        $seller_summary = $orderMould->seller_summary;
        $sku_count = $orderMould->sku_count;
        $buyer_tel = $orderMould->buyer_tel;
        $buyer_zip = $orderMould->buyer_zip;
        $buyer_province = $orderMould->buyer_province;
        $buyer_city = $orderMould->buyer_city;
        $buyer_county = $orderMould->buyer_county;
        $buyer_township = $orderMould->buyer_township;
        $express_name = $orderMould->express_name;
        $express_no = $orderMould->express_no;
        $express_content = $orderMould->express_content;
        $invoice_type = $orderMould->invoice_type;
        $invoice_header = $orderMould->invoice_header;
        $invoice_info = $orderMould->invoice_info;
        $invoice_added_value_tax = $orderMould->invoice_added_value_tax;
        $invoice_ordinary_number = $orderMould->invoice_ordinary_number;
        $freight = $orderMould->freight;
        $discount_money = $orderMould->discount_money;
        //读取execl文件
        $results = Excel::load($file, function($reader) {
        })->get();

        $results = $results->toArray();
        //订单总条数
        $total_count = count($results);
        //成功的订单号
        $success_outside_target_id = [];
        //重复的订单号
        $repeat_outside_target_id = [];
        //不存在的sku
        $no_sku_number = [];
        //空字段的订单号
        $null_field = [];
        //商品库存不够的单号
        $sku_quantity = [];

        foreach ($results as $d)
        {
            $new_data = [];
            foreach ($d as $v) {
                $new_data[] = $v;
            }

            $data = $new_data;
            if($outside_target_id >= 1){
                $outsideTargetId = $data[(int)$outside_target_id-1];
                $outside_target = OrderModel::where('outside_target_id', $outsideTargetId)->first();
                //订单重复导入
                if($outside_target){
                    $repeat_outside_target_id[] = $data[(int)$outside_target_id-1];
                    continue;
                }
            }
            if($sku_count >=1){
                $skuCount = $data[(int)$sku_count-1];
            }else{
                $skuCount = 1;
            }
            if($sku_number >= 1){
                $skuNumber = $data[(int)$sku_number-1];
                $sku = ProductsSkuModel::where('number' , $skuNumber)->first();
                //如果没有sku号码，存入到数组中
                if(!$sku){
                    $no_sku_number[] = $data[(int)$outside_target_id-1];
                    continue;
                }
                $product_sku_id = $sku->id;
                $product_id = $sku->product_id;
//                $price = $sku->price;

                //检查sku库存是否够用
                $product_sku_relation = new ProductSkuRelation();
                $product_sku = $product_sku_relation->skuInfo($user_id , $product_sku_id);
                $product_sku_quantity = $product_sku_relation->reduceSkuQuantity($product_sku_id , $user_id , $skuCount);
                if($product_sku_quantity[1] === false){
                    $sku_quantity[] = $data[(int)$outside_target_id-1];
                    continue;
                }
            }
            //姓名电话地址，有一个没写就返回记录
            if($buyer_name <1 || $buyer_phone <1 || $buyer_address <1){
                $null_field[] = $data[(int)$outside_target_id-1];
                continue;
            }

            $order = new OrderModel();
            $order->number = CountersModel::get_number('DD');
            $order->status = 5;
            $order->outside_target_id = $data[(int)$outside_target_id-1];
            $order->payment_type = 1;
            $order->type = 6;
            $order->payment_type = 1;
            $order->buyer_name = $data[(int)$buyer_name-1];
            $order->buyer_phone = $data[(int)$buyer_phone-1];
            $order->buyer_address = $data[(int)$buyer_address-1];
            $order->user_id = $user_id;
            $order->distributor_id = $user_id;
            $order->user_id_sales = config('constant.user_id_sales');
            $order->from_type = 2;
            $order->count = $skuCount;
            $order->total_money = $skuCount * $product_sku['price'];
            $order->order_start_time = $data[(int)$order_start_time-1] ? $data[(int)$order_start_time-1] : '0000-00-00 00:00:00';
            if($freight >=1){
                $order->freight = $data[(int)$freight-1];
            }
            if($discount_money >=1){
                $order->discount_money = $data[(int)$discount_money-1];
                $order->pay_money = ($skuCount * $product_sku['price']) - $data[(int)$discount_money-1];

            }else{
                $order->pay_money = $skuCount * $product_sku['price'];
            }
            if($buyer_tel >=1){
                $order->buyer_tel = $data[(int)$buyer_tel-1];
            }
            if($buyer_zip >=1){
                $order->buyer_zip = $data[(int)$buyer_zip-1];
            }
            if($buyer_province >=1){
                $order->buyer_province = $data[(int)$buyer_province-1];
            }
            if($buyer_city >=1){
                $order->buyer_city = $data[(int)$buyer_city-1];
            }
            if($buyer_county >=1){
                $order->buyer_county = $data[(int)$buyer_county-1];
            }
            if($buyer_township >=1){
                $order->buyer_township = $data[(int)$buyer_township-1];
            }
            if($buyer_summary >=1){
                $order->buyer_summary = $data[(int)$buyer_summary-1];
            }
            if($seller_summary >=1){
                $order->seller_summary = $data[(int)$seller_summary-1];
            }
            if($summary >=1){
                $order->summary = $data[(int)$summary-1];
            }
            if($invoice_type >=1){
                $order->invoice_type = $data[(int)$invoice_type-1];
            }
            if($invoice_header >=1){
                $order->invoice_header = $data[(int)$invoice_header-1];
            }
            if($invoice_info >=1){
                $order->invoice_info = $data[(int)$invoice_info-1];
            }
            if($invoice_added_value_tax >=1){
                $order->invoice_added_value_tax = $data[(int)$invoice_added_value_tax-1];
            }
            if($invoice_ordinary_number >=1){
                $order->invoice_ordinary_number = $data[(int)$invoice_ordinary_number-1];
            }
            if($express_no >=1){
                $order->express_no = $data[(int)$express_no-1];
            }
            if($express_content >=1){
                $order->express_content = $data[(int)$express_content-1];
            }
            if($express_name >=1){
                $express_name = $data[(int)$express_name-1];
                $logistics = LogisticsModel::where('name' , $express_name)->first();
                $order->express_id = $logistics->id;
            }

            if ($order->save()) {
                //保存收款单
                $receiveOrder = new ReceiveOrderModel();
                $receiveOrder->amount = $order->pay_money;
                $receiveOrder->payment_user = $order->buyer_name;
                $receiveOrder->type = 6;
                $receiveOrder->status = 1;
                $receiveOrder->target_id = $order->id;
//                $receiveOrder->user_id = Auth::user()?Auth::user()->id:0;
                $receiveOrder->user_id = $user_id;
                $number = CountersModel::get_number('SK');
                $receiveOrder->number = $number;
                $receiveOrder->save();

                //保存订单明细
                $order_sku = new OrderSkuRelationModel();
                $order_sku->order_id = $order->id;
                $product_sku = ProductsSkuModel::where('id', $product_sku_id)->first();
                $order_sku->sku_number = $product_sku->number;
                $order_sku->sku_id = $product_sku_id;
                $product = ProductsModel::where('id', $product_id)->first();
                $order_sku->product_id = $product_id;
                $order_sku->sku_name = $product->title . '--' . $product_sku->mode;
                $order_sku->quantity = $skuCount;
                $order_sku->price = $product_sku['price'];
                if(!$order_sku->save()) {
                    echo '订单详情保存失败';
                }
            }else{
                echo '订单保存失败';

            }
            //成功导入的订单号
            $success_outside_target_id[] = $data[(int)$outside_target_id-1];
        }

        //导入成功的站外订单号
        $success_outside = $success_outside_target_id;
        //成功导入的订单数
        $success_count = count($success_outside);
        //不存在sku编码的
        $no_sku = $no_sku_number;
        $no_sku_string = implode(',' , $no_sku);
        //没有找到sku的订单数
        $no_sku_count = count($no_sku);

        //重复的订单号
        $repeat_outside = $repeat_outside_target_id;
        $repeat_outside_string = implode(',' , $repeat_outside);
        //重复导入的订单数
        $repeat_outside_count = count($repeat_outside);

        //空字段的订单号
        $nullField = $null_field;
        $null_field_string = implode(',' , $nullField);
        //空字段的数量
        $null_field_count = count($nullField);

        //sku库存不够的
        $sku_storage_quantity = $sku_quantity;
        $sku_storage_quantity_string = implode(',' , $sku_storage_quantity);
        $sku_storage_quantity_count = count($sku_storage_quantity);

        $fileRecord = FileRecordsModel::where('id' , $file_records_id)->first();
        $file_record['status'] = 1;
        $file_record['total_count'] = $total_count ? $total_count  : 0;
        $file_record['success_count'] = $success_count ? $success_count : 0;
        $file_record['no_sku_count'] = $no_sku_count ? $no_sku_count : 0;
        $file_record['no_sku_string'] = $no_sku_string ? $no_sku_string : '';
        $file_record['repeat_outside_count'] = $repeat_outside_count ? $repeat_outside_count : 0;
        $file_record['repeat_outside_string'] = $repeat_outside_string ? $repeat_outside_string : '';
        $file_record['null_field_count'] = $null_field_count ? $null_field_count : 0;
        $file_record['null_field_string'] = $null_field_string ? $null_field_string : '';
        $file_record['sku_storage_quantity_count'] = $sku_storage_quantity_count ? $sku_storage_quantity_count : 0;
        $file_record['sku_storage_quantity_string'] = $sku_storage_quantity_string ? $sku_storage_quantity_string : '';
        $fileRecord->update($file_record);

        if($fileRecord->success_count == 0 && $fileRecord->repeat_outside_count== 0 && $fileRecord->null_field_count == 0 && $fileRecord->sku_storage_quantity_count == 0){
            $all_file['status'] = 2;
            $fileRecord->update($all_file);
        }

        echo 111;
    }
}
