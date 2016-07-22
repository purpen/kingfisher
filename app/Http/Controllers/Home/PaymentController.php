<?php

namespace App\Http\Controllers\Home;

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
            if(!EnterWarehousesModel::purchaseAdd($id)){
                $respond = ajax_json(0,'参数错误');
                DB::rollBack();
            }else{
                $purchase = new PurchaseController();
                $status = $purchase->changeStatus($id,2);
                if ($status){
                    $respond =  ajax_json(1,'记账成功');
                    DB::commit();
                }else{
                    $respond = ajax_json(0,'记账失败');
                    DB::rollBack();
                }
            }
            return $respond;
        }
        catch(\Exception $e){
            DB:roolBack();
            Log::error($e);
        }
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
