<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ChinaCityModel;
use App\Models\DistributorModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountController extends Controller
{
    public function index(Request $request)
    {
//        $products = $request->input('products');
//        $sku_id = $request->input('sku_id');
        $sku_id = 22;
        $start_time4 = "2018-08-20";
        $end_time4 = "2018-08-22";
//        $time_slot = $request->input('time_slot');//时间段跟下面的开始时间、结束时间每次只能选一个

        $count_money = DB::table('order_sku_relation')
            ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->where('order_sku_relation.sku_id','=',$sku_id)
            ->whereBetween('order.order_send_time', [$start_time4, $end_time4])
            ->select('order_sku_relation.quantity', 'order_sku_relation.price')
            ->get();

        var_dump($count_money);die;
        die;
        return view('home/count.count');
    }

//    铟立方总收入
    public function ingathering(Request $request)
    {
        //$start_time1 = $request->input('start_time1');
        //$end_time1 = $request->input('end_time1');
        $start_time1 = "2018-08-20";
        $end_time1 = "2018-08-22";

        $orders=DB::table('order_sku_relation')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->where('order.type','=',8)
            ->whereBetween('order.order_send_time', [$start_time1, $end_time1])
            ->get();
        if (count($orders)>0) {
            $ingathering = [];
            $order_send_time = [];
            foreach ($orders as $k => $v) {
                $ingathering[] = $v->quantity * $v->price;//收入
                $order_send_time[] = $v->order_send_time;//发货时间
            }
            return ajax_json(1, 'ok', $ingathering);

        }else{
            return ajax_json(0, 'error', '该时间段暂无订单收入！');
        }
    }

//    获取所有的商品名称
    public function products()
    {
        $products = ProductsModel::where('status', 2)
            ->orderBy('id', 'desc')
            ->get();
    }

//    ajax获取所选商品下所有的sku
    public function skus(Request $request)
    {
        //$product_id = (int)$request->input('product_id');
        $product_id = 21;
        $product_sku = ProductsSkuModel::where('product_id',$product_id)->get();//所有该商品下的sku

//        $product_sku = DB::table('order_sku_relation')
//            ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
//            ->where('products.id','=',$product_id)
//            ->select('order_sku_relation.id','order_sku_relation.sku_name')
//            ->get();//        sku_name
    }

//    获取所有门店所在省份
    public function province()
    {
        $province_id = DistributorModel::where('status',2)->select('province_id')->get();
        $province = [];
        foreach ($province_id as $v){
            $province[] = ChinaCityModel::where('oid',$v->province_id)->select('name')->first();
        }
        $provinces = array_unique($province);//去除重复的省份

    }

    //    获取所有省市下面的门店
    public function store(Request $request)
    {
//        $province_id = $request->input('province_id');
        $province_id = 27;

//        $store_names = DistributorModel::where('province_id',$province_id)->select('store_name')->get();
        $store_names = DistributorModel::where('province_id',$province_id)->get();
//        foreach ($store_names as $v){
//            $store_name[] = $v->store_name;
//        }
//        var_dump($store_names->toArray());
    }



//    根据sku跟时间算商品收入
    public function commodityIncome(Request $request)
    {
        $products = $request->input('products');
        $skus = $request->input('skus');
        $time_slot = $request->input('time_slot');//时间段跟下面的开始时间、结束时间每次只能选一个
        $start_time4 = $request->input('start_time4');
        $end_time4 = $request->input('end_time4');

        $count_money = DB::table('order_sku_relation')
            ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->where('order_sku_relation.id','=',$skus)
            ->whereBetween('order.order_send_time', [$start_time4, $end_time4])
            ->select('order_sku_relation.quantity', 'order_sku_relation.price')
            ->get();

    }

















}