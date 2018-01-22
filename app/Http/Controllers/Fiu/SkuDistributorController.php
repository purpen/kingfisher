<?php

namespace App\Http\Controllers\Fiu;

use App\Http\Models\User;
use App\Models\Distribution;
use App\Models\OrderMould;
use App\Models\ProductsModel;
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
            $skuDistributors = SkuDistributorModel::where('distributor_id' , $distributor_id)->orderBy('id' , 'desc')->paginate(15);
            $distributor = UserModel::where('id' , $distributor_id)->first();
        }else{
            $skuDistributors = SkuDistributorModel::orderBy('id' , 'desc')->paginate(15);
            $distributor = '';
        }
        $users = UserModel::where('type' , 1)->orderBy('id' , 'desc')->get();
        return view('fiu/skuDistributor.index', [
            'skuDistributors' => $skuDistributors,
            'users' => $users,
            'distributor' => $distributor,
            'search' => '',
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
        $skuDistributor1 = SkuDistributorModel::where('sku_number' , $sku_number)->where('distributor_id' , $distributor_id)->first();
        if($skuDistributor1){
            return back()->with('error_message', '该sku编码与分销商已绑定！')->withInput();

        }
        $skuDistributor2 = SkuDistributorModel::where('distributor_number' , $distributor_number)->where('distributor_id' , $distributor_id)->first();
        if($skuDistributor2){
            return back()->with('error_message', '该分销编码与分销商已绑定！')->withInput();
        }

        $skuDistributorObj = new SkuDistributorModel();
        $skuDistributorObj->sku_number = $sku_number;
        //拼接sku名称
        $sku = ProductsSkuModel::where('number' , $sku_number)->first();
        if($sku){
            $mode = $sku->mode;
            $product_id = $sku->product_id;
            $product = ProductsModel::where('id' , $product_id)->first();
            $product_name = $product->title;
            $skuDistributorObj->sku_name = $product_name.'--'.$mode;
        }else{
            $skuDistributorObj->sku_name = '';
        }
        //分销商名称
        $skuDistributorObj->distributor_id = $distributor_id;
        $distributor = Distribution::where('user_id' , $distributor_id)->first();
        if($distributor){
            $skuDistributorObj->distributor_name = $distributor->name;
        }else{
            $skuDistributorObj->distributor_name = '';

        }
        $skuDistributorObj->distributor_number = $distributor_number;
        if ($skuDistributorObj->save()) {
            return redirect('/fiu/saas/skuDistributor');
        } else {
            return back()->with('error_message', '保存失败！')->withInput();
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
//        $skuDistributor1 = SkuDistributorModel::where('sku_number' , $sku_number)->where('distributor_id' , $distributor_id)->where('distributor_number' , $distributor_number)->first();
//        if($skuDistributor1){
//            return back();
//
//        }
        $skuDistributorObj = SkuDistributorModel::find($id);
        if($skuDistributorObj){
            $skuDistributorObj->sku_number = $sku_number;
            $skuDistributorObj->distributor_number = $distributor_number;
            //拼接sku名称
            $sku = ProductsSkuModel::where('number' , $sku_number)->first();
            if($sku){
                $mode = $sku->mode;
                $product_id = $sku->product_id;
                $product = ProductsModel::where('id' , $product_id)->first();
                $product_name = $product->title;
                $skuDistributorObj->sku_name = $product_name.'--'.$mode;
            }else{
                $skuDistributorObj->sku_name = '';
            }
            //分销商名称
            $skuDistributorObj->distributor_id = $distributor_id;
            $distributor = Distribution::where('user_id' , $distributor_id)->first();
            if($distributor){
                $skuDistributorObj->distributor_name = $distributor->name;
            }else{
                $skuDistributorObj->distributor_name = '';

            }
            if ($skuDistributorObj->save()) {
                return redirect('/fiu/saas/skuDistributor');
            } else {
                return back()->with('error_message', '更新失败！')->withInput();
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

    /**
     * 搜索
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $skuDistributors = SkuDistributorModel::where('sku_number' ,'like','%'. $search.'%')->orWhere('distributor_number' ,'like','%'. $search.'%')->orWhere('sku_name' ,'like','%'. $search.'%')->orWhere('distributor_name' ,'like','%'. $search.'%')->orWhere('distributor_id' , $search)->orderBy('id', 'desc')->paginate(15);
        $users = UserModel::where('type' , 1)->orderBy('id' , 'desc')->get();

        return view("fiu/skuDistributor.index", [
            'search' => $search,
            'users' => $users,
            'skuDistributors' => $skuDistributors,
            'distributor' => '',

        ]);
    }

}
