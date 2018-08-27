<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ChinaCityModel;
use App\Models\DistributorModel;
use App\Models\OrderModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountController extends Controller
{
    public function index(Request $request)
    {
        
        return view('home/count.count');
    }

//    铟立方总收入
    public function ingathering(Request $request)
    {
        $start_time1 = $request->input('start_time1');
        $end_time1 = $request->input('end_time1');
        $ste = $request->input('ste');
//        $start_time1 = "2018-08-20";
//        $end_time1 = "2018-08-22";

        if ($ste == 2){
//            $this->lirun($start_time1,$end_time1);

        }
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

            $array = array();
            $array[0] = $ingathering;
            $array[1] = $order_send_time;
            return ajax_json(1, 'ok', $array);

        }else{
            return ajax_json(0, 'error', '该时间段暂无订单收入！');
        }
    }

    public function lirun($start_time1,$end_time1){//cost_price

        $res = DB::table('order_sku_relation')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
            ->where('order.type','=',8)
            ->whereBetween('order.order_send_time', [$start_time1, $end_time1])
            ->get();
        if (count($res)>0) {
            $ingathering = [];
            $order_send_time = [];
            foreach ($res as $k => $v) {
                $ingathering[] = $v->quantity * $v->price;//收入
                $order_send_time[] = $v->order_send_time;//发货时间
            }

            $array = array();
            $array[0] = $ingathering;
            $array[1] = $order_send_time;
            return ajax_json(1, 'ok', $array);

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
        return ajax_json(1, 'ok',$products);
    }

//    ajax获取所选商品下所有的sku
    public function skus(Request $request)
    {
        $product_id = (int)$request->input('products');
        $product_sku = ProductsSkuModel::where('product_id',$product_id)
            ->orderBy('id', 'desc')
            ->get();//所有该商品下的sku
        return ajax_json(1, 'ok',$product_sku);
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
        $time_slot = $request->input('time_slot','');//时间段跟下面的开始时间、结束时间每次只能选一个
        $start_time4 = $request->input('start_time4','');
        $end_time4 = $request->input('end_time4','');
//        $sku_id = $request->input('sku_id');
        $sku_id = 9;
        $start_time4 = date('Y-m-d 00:00:00',strtotime($start_time4));
        $end_time4 = date('Y-m-d 23:59:59',strtotime($end_time4));
        if ($time_slot == ''){
//            $send_time = OrderModel::select('order_send_time')->get();
//            foreach ($send_time as $value){
//                $order_send_time[] = substr($value->order_send_time,0,10);
//            }
            $count_money = DB::table('order_sku_relation')
                ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->where('order_sku_relation.sku_id','=',$sku_id)
                ->where('order.type','=',8)
                ->whereBetween('order.order_send_time', [$start_time4, $end_time4])
                ->select('order_sku_relation.quantity', 'order_sku_relation.price')
                ->get();
        }else{
            $now = date("Y-m-d H:i:s");
//            $time_slot = 1(最近7天) =2(最近30天) =3(最近60天) =4(最近90天)

            if ($time_slot == 1){
                $sql = DB::select("SELECT DATE_SUB(CURDATE(), INTERVAL 7 DAY) as time");//最近7天
            }else if ($time_slot == 2){
                $sql = DB::select("SELECT DATE_SUB(CURDATE(), INTERVAL 30 DAY) as time");//最近30天
            }else if ($time_slot == 3){
                $sql = DB::select("SELECT DATE_SUB(CURDATE(), INTERVAL 60 DAY) as time");//最近60天
            }else if ($time_slot == 4){
                $sql = DB::select("SELECT DATE_SUB(CURDATE(), INTERVAL 90 DAY) as time");//最近90天
            }
            $time = $sql[0]->time;
            $times = date('Y-m-d 00:00:00',strtotime($time));

            $count_money = DB::table('order_sku_relation')
                ->join('products', 'products.id', '=', 'order_sku_relation.product_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->where('order_sku_relation.sku_id','=',$sku_id)
                ->where('order.type','=',8)
                ->whereBetween('order.order_send_time', [$now, $times])
                ->select('order_sku_relation.quantity', 'order_sku_relation.price')
                ->get();
        }
//        var_dump($count_money);die;
        if (count($count_money)>0) {
            $ingathering = [];
            $order_send_time = [];
            foreach ($count_money as $k => $v) {
                $ingathering[] = $v->quantity * $v->price;//收入
                $order_send_time[] = $v->order_send_time;//发货时间
            }
            var_dump($ingathering);
            var_dump($order_send_time);die;

            $array = array();
            $array[0] = $ingathering;
            $array[1] = $order_send_time;
            return ajax_json(1, 'ok', $array);
        }else{
            return ajax_json(0, 'error', '该时间段暂无订单收入！');
        }
    }

















}