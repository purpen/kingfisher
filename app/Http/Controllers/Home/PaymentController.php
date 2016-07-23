<?php

namespace App\Http\Controllers\Home;

use App\Models\CountersModel;
use App\Models\EnterWarehouseSkuRelationModel;
use App\Models\EnterWarehousesModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\ReturnedPurchasesModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpSpec\Exception\Exception;

class paymentController extends Controller
{
    //付款首页展示
    public function home(){
        $purchases = PurchaseModel::where('verified',2)->orderBy('id','desc')->paginate(20);
        $count = PurchaseModel::where('verified',2)->count();
        $purchase = new PurchaseModel();
        $purchases = $purchase->lists($purchases);
        return view('home/payment.payment',['purchases' => $purchases,'count' => $count]);
    }

    /**
     * 财务记账,生成入库单
     * @param Request $request
     * @return string
     */
    public function ajaxCharge(Request $request)
    {
        $id = (int) $request->input('id');
        try{
            DB::beginTransaction();
            $purchase = new PurchaseModel();
            $status = $purchase->changeStatus($id,2);
            if($status){
                if ($this->purchaseAdd($id)){
                    $respond =  ajax_json(1,'记账成功');
                    DB::commit();
                }else{
                    $respond = ajax_json(0,'记账失败');
                    DB::rollBack();
                }
            }else{
                $respond = ajax_json(0,'记账失败');
                DB::rollBack();
            }
            return $respond;
        }
        catch(\Exception $e){
            DB:roolBack();
            Log::error($e);
        }
    }

    /**
     * 由通过财务审核记账的采购订单生成入库单
     * @param $purchase_id
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchaseAdd($purchase_id){
        $status = false;
        if(!$purchase = PurchaseModel::find($purchase_id)){
            return $status;
        }
        $enter = new EnterWarehousesModel();
        if(!$number = CountersModel::get_number('RKCG')){
            return view('errors.503');
        }
        $enter->number = $number;
        $enter->target_id = $purchase_id;
        $enter->type = 1;
        $enter->storage_id = $purchase->storage_id;
        $enter->count = $purchase->count;
        $enter->user_id = $purchase->user_id;
        if($enter->save()){
            $purchase_sku_s = PurchaseSkuRelationModel::where('purchase_id',$purchase_id)->get();
            foreach ($purchase_sku_s as $purchase_sku){
                $enter_warehouse_sku = new EnterWarehouseSkuRelationModel();
                $enter_warehouse_sku->enter_warehouse_id = $enter->id;
                $enter_warehouse_sku->sku_id = $purchase_sku->sku_id;
                $enter_warehouse_sku->count = $purchase_sku->count;
                if(!$enter_warehouse_sku->save()){
                    return $status;
                }
            }
            $status = true;
        }
        return $status;
    }

    /**
     * 财务驳回采购订单
     * @param Request $request
     * @return string
     */
    public function ajaxReject(Request $request){
        $id = (int) $request->input('id');
        if(!$purchase = PurchaseModel::find($id)){
            $respond = ajax_json(0,'参数错误！');
        }else{
            $purchase->verified = 0;
            if($purchase->save()){
                $respond = ajax_json(1,'驳回成功');
            }else{
                $respond = ajax_json(0,'驳回失败');
            }
        }
        return $respond;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
