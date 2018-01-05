<?php

namespace App\Http\Controllers\Fiu;

use App\Http\Models\User;
use App\Models\OrderMould;
use App\Models\SkuDistributorModel;
use App\Models\UserModel;
use function foo\func;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SkuDistributorController extends Controller
{

    /**
     * sku分销编码
     */
    public function index()
    {
        $skuDistributors = SkuDistributorModel::orderBy('id' , 'desc')->paginate(15);
        $users = UserModel::where('type' , 1)->orderBy('id' , 'desc')->get();
        return view('fiu/skuDistributor.index', [
            'skuDistributors' => $skuDistributors,
            'users' => $users,
        ]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sku_number = $request->input('sku_number');
        $distributor_id = $request->input('distributor_id');
        $distributor_number = $request->input('distributor_number');
        $skuDistributor = SkuDistributorModel::where('sku_number' , $sku_number)->where('distributor_id' , $distributor_id)->where('distributor_number' , $distributor_number)->first();
        if($skuDistributor){
            return back()->with('error_message', '该记录已存在！')->withInput();
        }else{
            $skuDistributorObj = new SkuDistributorModel();
            $skuDistributorObj->sku_number = $sku_number;
            $skuDistributorObj->distributor_id = $distributor_id;
            $skuDistributorObj->distributor_number = $distributor_number;
            if ($skuDistributorObj->save()) {
                return redirect('/fiu/saas/skuDistributor');
            } else {
                return back()->withInput();
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $skuDistributorObj = SkuDistributorModel::find($id);
        if ($skuDistributorObj) {
            return ajax_json(1, '获取成功', $skuDistributorObj);
        } else {
            return ajax_json(0, '数据不存在');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = (int)$request->input('id');
        $sku_number = $request->input('sku_number');
        $distributor_number = $request->input('distributor_number');
        $distributor_id = $request->input('distributor_id');
        $skuDistributor = SkuDistributorModel::where('sku_number' , $sku_number)->where('distributor_number' , $distributor_number)->where('distributor_id' , $distributor_id)->first();
        if($skuDistributor){
            return back()->with('error_message', '该记录已存在！')->withInput();

        }else{
            $skuDistributorObj = SkuDistributorModel::find($id);
            if($skuDistributorObj){
                $skuDistributorObj->sku_number = $request->input('sku_number');
                $skuDistributorObj->distributor_number = $request->input('distributor_number');
                $skuDistributorObj->distributor_id = $request->input('distributor_id');
                $res = $skuDistributorObj->save();
                if (!$res) {
                    return back()->withInput();
                }
                return redirect('/fiu/saas/skuDistributor');
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if (SkuDistributorModel::destroy($id)) {
            return ajax_json(1, '删除成功');
        } else {
            return ajax_json(0, '删除失败 ');

        }
    }

}
