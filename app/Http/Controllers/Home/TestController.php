<?php

namespace App\Http\Controllers\Home;

use App\Helper\ShopApi;
use App\Models\Membership;
use App\Models\OrderModel;
use App\Models\OrderUserModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\ProductUserRelation;
use App\Models\RefundMoneyOrderModel;
use App\Models\StoreModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
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
        $orders = OrderModel::where('user_id_sales' , 0)->get();
        foreach ($orders as $order)
        {
            $order->user_id_sales = $user_id_sales;
            $order->save();
        }
        return 6666;
    }
}
