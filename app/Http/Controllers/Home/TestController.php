<?php

namespace App\Http\Controllers\Home;

use App\Helper\ShopApi;
use App\Models\OrderModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\RefundMoneyOrderModel;
use App\Models\StoreModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
class TestController extends Controller
{
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



    public function ceShi()
    {
        $suppliers=DB::table('supplier')->get();
        foreach($suppliers as $supplier){
//            $number = DB::table('products')->where('number',$product->number)->count();
//            if($number>0){
//                continue;
//            }
            DB::table('suppliers')->insert(
                [
                    'name'=>$supplier->name,
                    'nam'=>$supplier->nam,
                    'summary'=>$supplier->summary,
                    'contact_user'=>$supplier->contact_user,
                    'contact_number'=>$supplier->contact_number,
                    'tel'=>$supplier->tel,
                    'address'=>$supplier->address,
                    'contact_qq'=>$supplier->contact_qq,
                    'summary'=>$supplier->summary

                ]);
        }

    }

    //手动运行订单，退款定时任务
    public function timingTask(){
//        $jdStore = StoreModel::where('platform',2)->get();
//        foreach($jdStore as $store){
//            $order = new OrderModel();
//            $order->saveOrderList($store->access_token,$store->id);
//
//            //$refund = new RefundMoneyOrderModel();
//            //$refund->saveRefundList($store->access_token,$store->id);
//        }
        $orderModel = new OrderModel();
//        $orderModel->autoChangeStatus();
        $orderModel->saveShopOrderList();
    }

    public function shopOrderTest()
    {
        $shopApi = new ShopApi();
//        $data = $shopApi->pullOrder(1);
        $data = $shopApi->send_goods(1, [],[]);
        dd($data);
    }
}
