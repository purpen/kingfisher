<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\UpdateProductSkuRequest;
use App\Models\AssetsModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\SkuRegionModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Http\Request;

use App\Http\Requests\ProductSkuRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductsSkuController extends Controller
{
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
        $productSku->product_number = $request->input('product_number');
        $productSku->number = $request->input('number');
        $productSku->summary = $request->input('summary');
        $productSku->user_id = Auth::user()->id;
        $productSku->cover_id = $request->input('cover_id');
        $productSku->unique_number = $request->input('unique_number');
        $productSku->zc_quantity = $request->input('zc_quantity') ? $request->input('zc_quantity') : 0;

        if($productSku->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $productSku->id;
                $asset->type = 4;
                $asset->save();
            }
            $min=array_values($request->input('min'));
            $max=array_values($request->input('max'));
            $sell_price=array_values($request->input('sell_price'));
            $sku_id = $productSku->id;
            $length = $request->input('length');

//          把一维数组转化成二维数组以便验证表单
            $mins = array('min'=>$min);
            $maxs = array('max'=>$max);
            $sell_prices = array('sell_price'=>$sell_price);
            $arrs = array("mins"=>'min',"maxs"=>'max',"sell_prices"=>'sell_price');
            $res = array();
            $result = count($mins['min']);

            for ($i=0;$i<$result;$i++){
                foreach ($arrs as $k=>$v){
                    $res[$i][$v]=${$k}[$v][$i];
                }
            }
//          判断第一行下限数量是否为1以及第二行开始下限数量是否为上一行上限数量+1
            foreach ($res as $k => $v){
                if ($k == 0) {
                    if ($v['min'] != 1) {
                        return back()->withErrors(['价格区间第一行下限数量必须从1开始！']);
                    }

                } else {
                if ($v['min'] - $res[$k - 1]['max'] != 1) {
                    return back()->withErrors(['价格区间从第二行开始每一行的下限数量需是上一行上限数量+1！']);
                }
                }
             }

            $num = intval($length);
            for ($i = 0;$i < $num;$i++){
                $sku_region = new SkuRegionModel();
                $sku_region->sku_id = $sku_id;
                $sku_region->min = $min[$i];
                $sku_region->max = $max[$i];
                $sku_region->sell_price = $sell_price[$i];
                $sku_region->user_id = Auth::user()->id;
                $sku_region->save();
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
            $asset->path = $asset->file->small;
        }
        $sku->assets = $assets;

        $region = SkuRegionModel::where('sku_id',$id)->orderBy('id','asc')->get();
        $sku_region = $region->toArray();
        $sku->sku_region = $sku_region;
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
        $purchaseCount = PurchaseSkuRelationModel::where('sku_id',$id)->count();
        $storageCount = StorageSkuCountModel::where('sku_id',$id)->count();
        $orderCount = OrderSkuRelationModel::where('sku_id',$id)->count();
        if($purchaseCount >0 || $storageCount > 0 || $orderCount > 0){
            return ajax_json(0,'该SKU已使用 不能删除');
        }

        $sku_region = SkuRegionModel::where('sku_id',$id)->get();//价格区间

        if(ProductsSkuModel::destroy((int)$id)){

            if (count($sku_region)>0) {
                foreach ($sku_region as $v) {
                    $v->forceDelete();
                }
            }

            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'删除失败');
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
        $sku = ProductsSkuModel::find((int)$request->input('id'));

        $rules = [
            'mode' => 'required|max:50',
            'bid_price' => 'required',
            'cost_price' => 'required',
            'price' => 'required',
            'unique_number' => 'required|unique:products_sku,unique_number,'.$sku->id,
        ];
        $messages = [
            'mode.required' => '颜色或型号不能为空',
            'mode.max' => '颜色或型号长度不能大于50个字符',
            'price.required' => '价格不能为空',
            'bid_price.required' => '标准进价不能为空',
            'cost_price.required' => '成本价不能为空',
            'unique_number.unique' => '品牌编号已存在',
        ];
        $this->validate($request, $rules,$messages);

        $sku->bid_price = $request->input('bid_price');
        $sku->cost_price = $request->input('cost_price');
        $sku->price = $request->input('price');
        $sku->mode = $request->input('mode');
        $sku->weight = $request->input('weight');
        $sku->summary = $request->input('summary');
        $sku->cover_id = $request->input('cover_id');
        $sku->unique_number = $request->input('unique_number');
        $sku->zc_quantity = $request->input('zc_quantity') ? $request->input('zc_quantity') : 0;
        if($sku->save()){
            $sku_id = $sku->id;
            if($sku->zc_quantity !== 0){
                $order_skus = OrderSkuRelationModel::where('sku_id' , $sku_id)->get();
                foreach($order_skus as $order_sku) {
                    $quantity['quantity'] = $sku->zc_quantity;
                    $order_sku->update($quantity);
                }
            }
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $sku->id;
                $asset->type = 4;
                $asset->save();
            }
            DB::table('sku_region')->where('sku_id', $sku->id)->delete();
            $min=array_values($request->input('mins'));
            $max=array_values($request->input('maxs'));
            $sell_price=array_values($request->input('sell_prices'));

            $sku_id = $sku->id;
            $length = $request->input('lengths');

            //把一维数组转化成二维数组以便验证表单
            $mins = array('min'=>$min);
            $maxs = array('max'=>$max);
            $sell_prices = array('sell_price'=>$sell_price);
            $arrs = array("mins"=>'min',"maxs"=>'max',"sell_prices"=>'sell_price');
            $res = array();
            $result = count($mins['min']);

            for ($i=0;$i<$result;$i++){
                foreach ($arrs as $k=>$v){
                    $res[$i][$v]=${$k}[$v][$i];
                }
            }
//          判断第一行下限数量是否为1以及第二行开始下限数量是否为上一行上限数量+1
            foreach ($res as $k => $v){
                if ($k == 0) {
                    if ($v['min'] != 1) {
                        return back()->withErrors(['价格区间第一行下限数量必须从1开始！']);
                    }

                } else {
                    if ($v['min'] - $res[$k - 1]['max'] != 1) {
                        return back()->withErrors(['价格区间从第二行开始每一行的下限数量需是上一行上限数量+1！']);
                    }
                }
            }

            $num = intval($length);
            for ($i = 0;$i < $num;$i++){
                $sku_region = new SkuRegionModel();
                $sku_region->sku_id = $sku_id;
                $sku_region->min = $min[$i];
                $sku_region->max = $max[$i];
                $sku_region->sell_price = $sell_price[$i];
                $sku_region->user_id = Auth::user()->id;
                $sku_region->save();
            }

            return back()->withInput();
        }else{
            return 'sku更改失败';
        }
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
        $supplier_id = $request->input('supplier_id');
        $productsSku = new ProductsSkuModel();
        $skus = $productsSku->lists($where,$supplier_id);
        if(empty($skus)){
            return ajax_json(0,'error','未查询到相关商品');
        }
        return ajax_json(1,'ok',$skus);
    }

    /**
     * 获取唯一商品SKU编码
     * @return int|string
     */
    public function uniqueNumber(){
        $number = getNumber();
        if(ProductsSkuModel::where('number',$number)->count() > 0){
            $number = $this->uniqueNumber();
        }
        return ajax_json(1,'ok',$number);
    }

    /**
     * 判断数据库是否存在站外编号
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string json
     */
    public function uniqueNumberCaptcha(Request $request)
    {
        $result = ProductsSkuModel::where('unique_number', $request['unique_number'])->first();
        if(!$result){
            return ajax_json(0, '该站外编号还没有！');
        }
        return ajax_json(1, '该站外编号已存在！');
    }
}
