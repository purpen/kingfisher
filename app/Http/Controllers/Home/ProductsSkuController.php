<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\UpdateProductSkuRequest;
use App\Models\AssetsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;

use App\Http\Requests\ProductSkuRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsSkuController extends Controller
{
    //生成10位数字字符sku
    protected function get_product_sku($prefix=1){

        $sku  = $prefix;
        $val = DB::table('products_sku')->max('id');
        $val = $val + 1;

        $len = strlen((string)$val);
        if ($len <= 5) {
            $sku .= date('md');
            $sku .= sprintf("%05d", $val);
        }else{
            $sku .= substr(date('md'), 0, 9 - $len);
            $sku .= $val;
        }
        return $sku;
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
    public function store(ProductSkuRequest $request)
    {
        $productSku = new ProductsSkuModel();
        $productSku->bid_price = $request->input('bid_price');
        $productSku->cost_price = $request->input('cost_price');
        $productSku->price = $request->input('price');
        $productSku->mode = $request->input('mode');
        $productSku->product_id = $request->input('product_id');
        $productSku->number = $request->input('number');
        $productSku->summary = $request->input('summary');
        $productSku->user_id = Auth::user()->id;
        $productSku->cover_id = $request->input('cover_id');
        if($productSku->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $productSku->id;
                $asset->type = 4;
                $asset->save();
            }
            return back()->withInput();
        }else{
            return '添加失败';
        }

    }

    /**
     * 获取需要编辑sku数据
     * @param $id
     * @return string
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        if(!$sku = ProductsSkuModel::find((int)$id)){
            return ajax_json(0,'error');
        }
        $assets = AssetsModel::where(['target_id' => $id,'type' => 4])->get();
        foreach ($assets as $asset){
            $asset->path = config('qiniu.url') . $asset->path . config('qiniu.small');
        }
        $sku->assets = $assets;
        return ajax_json(1,'ok',$sku);
    }

    /**
     * 删除sku
     * @param Request $request
     * @return string
     */
    public function ajaxDestroy(Request $request)
    {
       $id = $request->input('id');
        if(ProductsSkuModel::destroy((int)$id)){
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'删除失败');
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
    public function update(UpdateProductSkuRequest $request)
    {
        $sku = ProductsSkuModel::find((int)$request->input('id'));
        $sku->bid_price = $request->input('bid_price');
        $sku->cost_price = $request->input('cost_price');
        $sku->price = $request->input('price');
        $sku->mode = $request->input('mode');
        $sku->weight = $request->input('weight');
        $sku->summary = $request->input('summary');
        $sku->cover_id = $request->input('cover_id');
        if($sku->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $sku->id;
                $asset->type = 4;
                $asset->save();
            }
            return back()->withInput();
        }else{
            return 'sku更改失败';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }

    /**
     * 按供应商获取sku列表
     * @param Request $request
     * @return string
     */
    public function ajaxSkus(Request $request){
        $supplier_id = $request->input('supplier_id');
        $productsSku = new ProductsSkuModel();
        $skus = $productsSku->lists(null,$supplier_id);
        return ajax_json(1,'ok',$skus);
    }

    /**
     * 使用名称或编号查询sku
     * @param Request $request
     * @return string
     */
    public function ajaxSearch(Request $request){
        $where = $request->input('where');
        $productsSku = new ProductsSkuModel();
        $skus = $productsSku->lists($where);
        return ajax_json(1,'ok',$skus);
    }
}
