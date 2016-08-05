<?php

namespace App\Http\Controllers\Home;

use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsSkuModel;
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
        return view('home/order.order');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home/order.createOrder');
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
            $all['user_id'] = Auth::user()->id;
            $all['status'] = 5;

            $total_money = 0.00;
            $discount_money = 0.00;
            for($i=0;$i<count($all['quantity']);$i++){
                $total_money += $all['quantity'][$i] * $all['price'][$i] * 100;
                $discount_money += $all['discount'];
            }
            $all['total_money'] = $total_money/100;
            $all['discount_money'] = $discount_money;
            $all['pay_money'] = ($total_money/100) + $all['freight'] - $discount_money;

            DB::beginTransaction();
            if(!$order_model = OrderModel::create($all)){
                DB::rollBack();
                return '参数错误';
            }
            $order_id = $order_model->id;
            for($i=0;$i<count((array)$all['sku_id']);$i++){
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_id = $all['sku_id'][$i];
                $order_sku_model->product_id = ProductsSkuModel::find($all['sku_id'][$i])->product->id;
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
        }
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
