<?php

namespace App\Http\Controllers\Fiu;

use App\Http\Models\User;
use App\Models\OrderMould;
use App\Models\ProductsSkuModel;
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
    public function index(Request $request)
    {
        $distributor_id = $request->input('id');
        if($distributor_id){
            $skuDistributors = SkuDistributorModel::where('distributor_id' , $distributor_id)->orderBy('distributor_id' , 'desc')->paginate(15);
        }else{
            $skuDistributors = SkuDistributorModel::orderBy('distributor_id' , 'desc')->paginate(15);
        }
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
        $productSkus = ProductsSkuModel::orderBy('id' , 'desc')->get();
        $users = UserModel::where('type', 1)->orderBy('id' , 'desc')->get();
        return view('fiu/skuDistributor.create', [
            'productSkus' => $productSkus,
            'users' => $users,
        ]);
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
                return back()->with('error_message', '保存失败！')->withInput();
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
//    public function ajaxEdit(Request $request)
//    {
//        $id = $request->input('id');
//        $skuDistributorObj = SkuDistributorModel::find($id);
//        if ($skuDistributorObj) {
//            return ajax_json(1, '获取成功', $skuDistributorObj);
//        } else {
//            return ajax_json(0, '数据不存在');
//        }
//    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $skuDistributorObj = SkuDistributorModel::find($id);
        $productSkus = ProductsSkuModel::orderBy('id' , 'desc')->get();
        $users = UserModel::where('type', 1)->orderBy('id' , 'desc')->get();
        if ($skuDistributorObj) {
            return view('fiu/skuDistributor.edit', [
                'productSkus' => $productSkus,
                'users' => $users,
                'skuDistributorObj' => $skuDistributorObj,
            ]);

        }else{
            return back()->with('error_message', '没有找到！')->withInput();

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

                if ($skuDistributorObj->save()) {
                    return redirect('/fiu/saas/skuDistributor');
                } else {
                    return back()->with('error_message', '更新失败！')->withInput();
                }
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
