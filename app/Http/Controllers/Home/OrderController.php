<?php

namespace App\Http\Controllers\Home;

use App\Models\CountersModel;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageModel;
use App\Models\StorageSkuCountModel;
use App\Models\StoreModel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_list = OrderModel::orderBy('id','desc')->paginate(20);
        return view('home/order.order',['order_list' => $order_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storage_list = StorageModel::select('id','name')->where('status',1)->get();

        $store_list = StoreModel::select('id','name')->get();

        $logistic_list = LogisticsModel::select('id','name')->where('status',1)->get();
        return view('home/order.createOrder',['storage_list' => $storage_list, 'store_list' => $store_list,'logistic_list' => $logistic_list]);
    }

    public function ajaxOrder(Request $request){
        return ajax_json(1,'ok');
    }

    /**
     * 获取指定仓库sku列表
     * @param Request $request
     * @return string
     */
    public function ajaxSkuList(Request $request){
        $storage_id = (int)$request->input('id');
        if(empty($storage_id)){
            return ajax_json(0,'参数错误');
        }
        $storage_sku_model = new StorageSkuCountModel();
        $sku_list = $storage_sku_model->skuList($storage_id);
        return ajax_json(1,'ok',$sku_list);
    }

    /**
     * 创建一个新的订单.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try{
            $all = $request->all();

            $total_money = 0.00;
            $discount_money = 0.00;
            $count = 0;
            for($i=0;$i<count($all['quantity']);$i++){
                $total_money += $all['quantity'][$i] * $all['price'][$i] * 100;
                $discount_money += $all['discount'][$i];
                $count += $all['quantity'][$i];
            }


            $all = $request->except(['sku_id','sku_storage_id','price','quantity','discount']);
            $all['user_id'] = Auth::user()->id;
            $all['status'] = 5;
            $all['total_money'] = $total_money/100;
            $all['discount_money'] = $discount_money;
            $all['pay_money'] = ($total_money/100) + $all['freight'] - $discount_money;
            $all['count'] = $count;
            
            $counters = CountersModel::get_number('DD');
            $all[$counters] = $counters;
            DB::beginTransaction();
            if(!$order_model = OrderModel::create($all)){
                DB::rollBack();
                return '参数错误';
            }

            $all = $request->all();
            $order_id = $order_model->id;
            for($i=0;$i<count($all['sku_id']);$i++){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->storage_id = $all['sku_storage_id'][$i];
                $order_sku_model->sku_id = $all['sku_id'][$i];
                $product_sku_id = $all['sku_id'][$i];
                if(!$product_sku_model = ProductsSkuModel::find($product_sku_id)){
                    var_dump($all['sku_id']);
                    DB::rollBack();
                    return '参数错误';
                }
                $order_sku_model->product_id = $product_sku_model->product->id;
                $order_sku_model->quantity = $all['quantity'][$i];
                $order_sku_model->price = $all['price'][$i];
                $order_sku_model->discount = $all['discount'][$i];
                if(!$order_sku_model->save()){
                    DB::rollBack();
                    return '参数错误';
                }
            }
            DB::commit();
            return redirect('/order');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            dd($e);
        }
    }

    /**
     * 获取订单及订单明细的详细信息
     * @param Request $request
     * @return string
     */
    public function ajaxEdit(Request $request){
        $order_id = (int)$request->input('id');
        if(empty('id')){
            return ajax_json(0,'error');
        }
        $order = OrderModel::find($order_id); //订单

        $order_sku = OrderSkuRelationModel::where('order_id',$order_id)->get();
        $product_sku_modle = new ProductsSkuModel();
        $order_sku = $product_sku_modle->detailedSku($order_sku); //订单明细

        $storage_list = StorageModel::select('id','name')->where('status',1)->get();   //仓库

        $logistic_list = LogisticsModel::select('id','name')->where('status',1)->get();  //物流

        $data = ['order' => $order,'order_sku' => $order_sku,'storage_list' => $storage_list,'logistic_list' => $logistic_list];
        return ajax_json(1,'ok',$data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
