<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Common\AssetController;
use App\Models\AssetsModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function home()
    {
        $category = new CategoriesModel();
        $asset = new AssetsModel();
        $lists = $category->lists(0,1);                         //分类列表
        $products = ProductsModel::orderBy('id','desc')->paginate(5);
        foreach ($products as $product){
            $path = $asset->path($product->cover_id);
            $product->path = $path;
            $skus = $product->productsSku()->get();
            foreach ($skus as $v){
                $v->path = $asset->path($v->cover_id);
            }
            $product->skus = $skus;

        }

        return view("home/product.home",['lists' => $lists,'products' => $products]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new CategoriesModel();
        $lists = $category->lists();
        $random = uniqid();  //获取唯一字符串
        $suppliers = SupplierModel::select('id','name')->get();
        $user_id = Auth::user()->id;
        $assetController = new AssetController();
        $token = $assetController->upToken();
        return view('home/product.create',['lists' => $lists,'random' => $random,'suppliers' => $suppliers,'user_id' => $user_id,'token' => $token]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new ProductsModel();
        $product->number = $request->input('number');
        $product->title = $request->input('title');
        $product->tit = $request->input('tit');
        $product->category_id = $request->input('category_id');
        $product->supplier_id = $request->input('supplier_id');
        $product->supplier_name = $request->input('supplier_name');
        $product->market_price = $request->input('market_price','');
        $product->sale_price = $request->input('sale_price');
        $product->cost_price = $request->input('cost_price');
        $product->cover_id = $request->input('cover_id','');
        $product->unit = $request->input('unit','');
        $product->weight = $request->input('weight');
        $product->summary = $request->input('summary','');
        $product->type = 1;
        $product->user_id = Auth::user()->id;
        if($product->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $product->id;
                $asset->type = 1;
                $asset->save();
            }
            return redirect('/product');
        }else{
            return "添加失败";
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = (int)$request->input('id');
        $category = new CategoriesModel();
        $lists = $category->lists();  //分类列表
        $supplier = new SupplierModel;
        $suppliers = $supplier->lists();  //供应商列表
        $product = ProductsModel::find($id);
        $skus = $product->productsSku()->get();
        $assets = new AssetsModel();
        foreach ($skus as $v){
            $v->path = $assets->path($v->cover_id);
        }
        $assetController = new AssetController();
        $token = $assetController->upToken();
        $user_id = Auth::user()->id;
        $assets = AssetsModel::where(['target_id' => $id,'type' => 1])->get();
        foreach ($assets as $asset){
            $asset->path = config('qiniu.url') . $asset->path . config('qiniu.small');
        }

        $random = [];
        for ($i = 0; $i<2; $i++){
            $random[] = uniqid();  //获取唯一字符串
        }

        $url = $_SERVER['HTTP_REFERER'];
        if(!Cookie::has('product_back_url')){
            Cookie::queue('product_back_url', $url, 60);  //设置修改完成转跳url
        }
        return view('home/product.edit',['product' => $product,'skus' => $skus,'lists' => $lists,'suppliers' => $suppliers,'token' => $token,'user_id' => $user_id,'assets' => $assets,'url' => $url,'random' => $random]);
    }

    /**
     * @param Request $request
     * @return $this|string
     */
    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:50',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'sale_price' => 'required',
            'number' => 'required|unique:products,number,'.$request->input('product_id'),
        ];
        $messages = [
            'title.required' => '名称不能为空',
            'title.max' => '名称长度不能大于50',
            'category_id.required' => '请选择分类',
            'supplier_id.required' => '请选择供应商',
            'sale_price.required' => '销售价格不能为空',
            'number.required' => '货号不能为空',
            'number.unique' => '货号已存在',
        ];
        $this->validate($request, $rules,$messages);
        $id = $request->input('product_id');
        $product = ProductsModel::find($id);
        if($product->update($request->all())){
            $url = Cookie::get('product_back_url');
            Cookie::forget('product_back_url');
            return redirect($url);
        }else{
            return "更新失败";
        }
    }

    /**
     * 删除商品
     * @param Request $request
     * @return string
     */
    public function ajaxDestroy(Request $request)
    {
        $id_arr = $request->input('id');
        if(ProductsModel::destroy($id_arr)){
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'删除失败');
        }


    }

    /*
     *商品搜索
     */
    public function search(Request $request)
    {
        $name = $request->input('name');
        $products = ProductsModel::where('number','like','%'.$name.'%')->orWhere('title','like','%'.$name.'%')->orWhere('tit','like','%'.$name.'%')->paginate(20);
        $asset = new AssetsModel();
        foreach ($products as $product){
            $path = $asset->path($product->cover_id);
            $product->path = $path;
            $skus = $product->productsSku()->get();
            foreach ($skus as $v){
                $v->path = $asset->path($v->cover_id);
            }
            $product->skus = $skus;

        }
        if ($products){
            return view('home/product.home',['products'=>$products]);
        }
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
