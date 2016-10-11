<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PaymentAccountModel;
use App\Models\StoreModel;

class PaymentAccountController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = StoreModel::orderBy('id','desc')->get();
        $paymentAccount = PaymentAccountModel::orderBy('id','desc')->get();
        return view('home/paymentaccount.paymentaccount',['store' => $store,'paymentAccount' => $paymentAccount]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentAccount = new PaymentAccountModel();
        $paymentAccount->store_id = $request->input('store_id');
        $paymentAccount->bank = $request->input('bank');
        $paymentAccount->account = $request->input('account');
        $paymentAccount->summary = $request->input('summary');
        $result = $paymentAccount->save();
        if($result){
            return back()->withInput();
        }else{
            return '添加失败';
        }
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $paymentAccount = PaymentAccountModel::find($id);
        if ($paymentAccount){
            return ajax_json(1,'获取成功',$paymentAccount);
        }else{
            return ajax_json(0,'数据不存在');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $paymentAccount = PaymentAccountModel::find($id);
        if($paymentAccount->update($request->all())){
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if(PaymentAccountModel::destroy($id)){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
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

    }



}
