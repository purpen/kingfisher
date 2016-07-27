<?php

namespace App\Http\Controllers\Home\Product;

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
        $productSku->price = $request->input('price');
        $productSku->mode = $request->input('mode');
        $productSku->product_id = $request->input('product_id');
        $productSku->name = $request->input('name');
        $productSku->number = $this->get_product_sku();
        $productSku->user_id = Auth::user()->id;
        if($productSku->save()){
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
        if($sku = ProductsSkuModel::find((int)$id)){
            return ajax_json(1,'ok',$sku);
        }else{
            return ajax_json(0,'error');
        }
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
    public function update(ProductSkuRequest $request)
    {
        $sku = ProductsSkuModel::find((int)$request->input('id'));
        $sku->price = $request->input('price');
        $sku->mode = $request->input('mode');
        if($sku->save()){
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
}
