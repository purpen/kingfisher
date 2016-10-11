<?php

namespace App\Http\Controllers\Home;

use App\Models\CountersModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsSkuModel;
use App\Models\RefundGoodsOrderModel;
use App\Models\RefundSkuRelationModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    

    //退款单
    public function refundMoney()
    {
        $refund = RefundGoodsOrderModel::where('type',2)->paginate(20);
        return view('home/refund.refundMoney');
    }

    //创建售后订单退款单页面
    public function createRefundMoney()
    {
        
        return view('home/refund.createRefundMoney');
    }

    /**
     * 获取订单信息
     * @param Request $request
     * @return string
     */
    public function ajaxOrder(Request $request)
    {
        $number = $request->input('number');
        $purchase = OrderModel::where('number',$number)->first();
        if(!$purchase){
            return ajax_json(0,'error1');
        }
        
        $purchase_sku = OrderSkuRelationModel::where('order_id',$purchase->id)->get();
        if(!$purchase_sku){
            return ajax_json(0,'error2');
        }
        $product = new ProductsSkuModel();
        $purchase_sku  = $product->detailedSku($purchase_sku);
        return ajax_json(1,'ok',['purchase' => $purchase, 'purchase_sku' => $purchase_sku]);
    }
    
    /**
     * 创建售后退款订单及明细
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeRefundGood(Request $request)
    {
        try
        {
            $order_id = (int)$request->input('order_id');
            $sku_id = (array)$request->input('sku_id');
            $quantity = (array)$request->input('quantity');
            $price = (array)$request->input('price');
            $summary = $request->input('summary');

            $amount = 0.00;
            for ($i = 0; $i < count($sku_id); $i++){
                $amount += $quantity[$i] * $price[$i];
            }

            DB::beginTransaction();
            $number = CountersModel::get_number('DDTK');
            if(!$number){
                DB::rollBack();
                return back()->withInput('error_message','内部错误');
            }

            $refundModel = new RefundGoodsOrderModel();
            $refundModel->number = $number;
            $refundModel->order_id = $order_id;
            $refundModel->amount = $amount;
            $refundModel->type = 2;
            $refundModel->summary = $summary;
            if(!$refundModel->save()){
                DB::rollBack();
                return back()->withInput('error_message','保存失败');
            }

            for ($i = 0; $i < count($sku_id); $i++){
                $refund_sku = new RefundSkuRelationModel();
                $refund_sku->refund_goods_order_id = $refundModel->id;
                $refund_sku->sku_id = $sku_id[$i];
                $refund_sku->quantity = $quantity[$i];
                if(!$refund_sku->save()){
                    DB::rollBack();
                    return back()->withInput('error_message','保存失败');
                }
            }
            DB::commit();
            return redirect('/refund/refundMoney');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->withInput('error_message','保存失败');
        }
    }
    
    //创建退款单
    public function storeRefundMoney(){
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
