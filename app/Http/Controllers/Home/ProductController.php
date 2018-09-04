<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Http\Controllers\Common\AssetController;
use App\Models\AssetsModel;
use App\Models\CategoriesModel;
use App\Models\ChinaCityModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageSkuCountModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->tab_menu = 'default';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->display_tab_list(null);
    }

    /**
     * 待上架商品列表
     */
    public function unpublishList(Request $request)
    {
        $this->tab_menu = 'unpublish';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->display_tab_list(1);
    }

    /**
     * 在售商品列表
     */
    public function saleList(Request $request)
    {
        $this->tab_menu = 'saled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->display_tab_list(2);
    }

    /**
     * 已取消合作商品列表
     */
    public function cancList(Request $request)
    {
        $this->tab_menu = 'canceled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->display_tab_list(3);
    }

    /**
     * 商品列表
     */
    protected function display_tab_list($status = null)
    {
        $name = '';
        // 分类列表
        $category = new CategoriesModel();
        $lists = $category->lists(0,1);

        if ($status === null){
            $products = ProductsModel::orderBy('id','desc')->paginate($this->per_page);
        }else{
            $products = ProductsModel::where('status',$status)->orderBy('id','desc')->paginate($this->per_page);
        }

        $skus = ProductsSkuModel::orderBy('id','desc')->get();
        $suppliersModel = new SupplierModel();
        $suppliers = $suppliersModel->supplierList();
        $skuId = [];
        foreach($skus as $sku){
            $skuId[] = $sku->product_id;
        }
        return view("home/product.home", [
            'lists' => $lists,
            'products' => $products,
            'tab_menu' => $this->tab_menu,
            'skuId' => $skuId,
            'name' => $name,
            'per_page' => $this->per_page,
            'suppliers' => $suppliers,
            'supplier_id' => 0,
        ]);
    }

    /**
     * 获取唯一商品编码
     * @return int|string
     */
    public function uniqueNumber(){
        $number = getNumber();
        if(ProductsModel::where('number',$number)->count() > 0){
            $number = $this->uniqueNumber();
        }
        return $number;
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
        $suppliersModel = new SupplierModel();
        $suppliers = $suppliersModel->supplierList();
        $user_id = Auth::user()->id;

        //获取七牛上传token
        $token = QiniuApi::upToken();

        /*获取商品编码  暂时让自己手添*/
//        $number = $this->uniqueNumber();'number' => $number,

        $this->tab_menu = 'default';

        $province = new ChinaCityModel();
        $provinces = $province->fetchCity();//所有省

        return view('home/product.create',['lists' => $lists,'random' => $random,'suppliers' => $suppliers,'user_id' => $user_id,'token' => $token, 'tab_menu' => $this->tab_menu,'name' => '', 'supplier_id' => 0,
        'provinces'=>$provinces]);
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
//        $product->product_type = $request->input('product_type');
        $product->title = $request->input('title');
        $product->tit = $request->input('tit');
        $product->category_id = $request->input('category_id');
        $product->region_id = $request->input('diyu');//地域分类

        $product->authorization_id = $request->input('Jszzdm');//授权条件
        $product->supplier_id = $request->input('supplier_id','');
        $product->supplier_name = SupplierModel::find($product->supplier_id)->nam;
        $product->market_price = $request->input('market_price','');
        $product->sale_price = $request->input('sale_price');
        $product->cost_price = $request->input('cost_price');
        $product->cover_id = $request->input('cover_id','');
        $product->unit = $request->input('unit','');
        $product->weight = $request->input('weight');
        $product->summary = $request->input('summary','');
        $product->type = 1;
        $product->user_id = Auth::user()->id;
        $product->product_details = $request->input('product_details','');
        if($product->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $product->id;
//                $asset->type = 1;
                $asset->save();
            }
            return redirect('/product/edit?id='.$product->id);
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
        $lists = $category->lists();  // 分类列表

        // 供应商列表
        $suppliersModel = new SupplierModel();
        $suppliers = $suppliersModel->supplierList();

        $product = ProductsModel::find($id);

        $authorization_id = explode(",",$product->authorization_id);

        $region = explode(",",$product->region_id);
        //获取七牛上传token
        $token = QiniuApi::upToken();

        $user_id = Auth::user()->id;

        //获取商品的图片
        $assets = AssetsModel::where(['target_id' => $id,'type' => 1])->get();
        //获取商品详情的图片
        $assetsProductDetails = AssetsModel::where(['target_id' => $id,'type' => 22])->get();

        $random = [];
        for ($i = 0; $i<2; $i++) {
            $random[] = uniqid();  //获取唯一字符串
        }

        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if(!Cookie::has('product_back_url')){
            Cookie::queue('product_back_url', $url, 60);  // 设置修改完成转跳url
        }
        $this->tab_menu = 'default';


        $province = new ChinaCityModel();
        $provinces = $province->fetchCity();//所有省

        return view('home/product.edit', [
            'product' => $product,
            'lists' => $lists,
            'suppliers' => $suppliers,
            'authorization' =>$authorization_id,
            'region' =>$region,
            'provinces' => $provinces,
            'token' => $token,
            'user_id' => $user_id,
            'assets' => $assets,
            'assetsProductDetails' => $assetsProductDetails,
            'url' => $url,
            'random' => $random,
            'tab_menu' => $this->tab_menu,
            'name' => '',
            'supplier_id' => 0,
        ]);
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
            'authorization_id' => 'required',
            'region_id' => 'required',
//            'supplier_id' => 'required',
            'sale_price' => 'required',
            'number' => 'required|unique:products,number,'.$request->input('product_id'),
        ];
        $messages = [
            'title.required' => '名称不能为空',
            'title.max' => '名称长度不能大于50',
            'category_id.required' => '请选择分类',
            'authorization_id.required' => '请选择授权类型',
            'region_id.required' => '请选择地域分类',
//            'supplier_id.required' => '请选择供应商',
            'sale_price.required' => '销售价格不能为空',
            'number.required' => '货号不能为空',
            'number.unique' => '货号已存在',
        ];
        $this->validate($request, $rules,$messages);
        $id = (int)$request->input('product_id');
        $product = ProductsModel::find($id);

        $product->number = $request->input('number');
//        $product->product_type = $request->input('product_type');
        $product->title = $request->input('title');
        $product->tit = $request->input('tit');
        $product->category_id = $request->input('category_id');
        $authorization = $request->input('authorization_id');
        $product->authorization_id = implode(',',$authorization);
        $region = $request->input('region_id');
        $product->region_id = implode(',',$region);
        $product->supplier_id = $request->input('supplier_id','');
        $product->supplier_name = SupplierModel::find($product->supplier_id)->nam;
        $product->market_price = $request->input('market_price','');
        $product->sale_price = $request->input('sale_price');
        $product->cost_price = $request->input('cost_price');
        $product->cover_id = $request->input('cover_id','');
        $product->unit = $request->input('unit','');
        $product->weight = $request->input('weight');
        $product->summary = $request->input('summary','');
        $product->type = 1;
        $product->user_id = Auth::user()->id;
        $product->product_details = $request->input('product_details','');
        $result = $product->update();

        if($result){

            $url = Cookie::get('product_back_url');
            Cookie::forget('product_back_url');
//            return redirect($url);
            return redirect('/product');
        }else{
            return "更新失败";
        }
    }

    /**
     * 批量上架商品
     * @param Request $request
     * @return string
     */
    public function upShelves(Request $request)
    {
        $id_arr = $request->input('id');

        foreach ($id_arr as $id){
            $productModel = ProductsModel::find($id);
            if($productModel->status != 1){
                return ajax_json(0,'该商品已上架或已取消不能上架');
            }
            if($productModel->productsSku->isEmpty()){
                return ajax_json(0,'该商品未添加SKU不能上架');
            }
            if($productModel->inventory < 1){
                return ajax_json(0,'该商品库存为0不能上架');
            }
            if(!$productModel->changeProduct(2)){
                return ajax_json(0,$productModel->tit . '上架失败');
            }
        }

        return ajax_json(1,'商品上架成功');
    }

    /**
     * 批量下架商品
     * @param Request $request
     * @return string
     */
    public function downShelves(Request $request)
    {
        $id_arr = $request->input('id');

        foreach ($id_arr as $id){
            $productModel = ProductsModel::find($id);
            if($productModel->status != 2){
                return ajax_json(0,'该商品已下架或已取消不能下架');
            }
            if(!$productModel->changeProduct(1)){
                return ajax_json(0,$productModel->tit . '下架失败');
            }
        }

        return ajax_json(1,'商品下架成功');
    }

    /**
     * 取消商品
     * @param Request $request
     * @return string
     */
    public function ajaxDestroy(Request $request)
    {
        $id_arr = $request->input('id');

        foreach ($id_arr as $id){
            $productModel = ProductsModel::find($id);
            if($productModel->status == 3){
                return ajax_json(0,'该商品已取消，不能重复取消');
            }
            if(!$productModel->changeProduct(3)){
                return ajax_json(0,$productModel->tit . '删除失败');
            }
        }

        return ajax_json(1,'删除商品成功');
    }

    /*
     *商品搜索
     */
    public function search(Request $request)
    {
        $this->per_page = $request->input('per_page',$this->per_page);
        $name = $request->input('search');
        $supplier_id = $request->input('supplier_id') ? $request->input('supplier_id') : 0;
        if($supplier_id !== 0){
            $products = ProductsModel::where('supplier_id' , $supplier_id)->paginate($this->per_page);
        }else{
            $sku = ProductsSkuModel::where('number' , 'like','%'.$name.'%')->first();
            if($sku){
                $products = ProductsModel::where('id', $sku->product_id)->orWhere('title','like','%'.$name.'%')->orWhere('tit','like','%'.$name.'%')->paginate($this->per_page);
            }else{
                $products = ProductsModel::where('number','like','%'.$name.'%')->orWhere('title','like','%'.$name.'%')->orWhere('tit','like','%'.$name.'%')->paginate($this->per_page);

            }
        }
        $skus = ProductsSkuModel::orderBy('id','desc')->get();
        $skuId = [];
        foreach($skus as $sku){
            $skuId[] = $sku->product_id;
        }
        $suppliersModel = new SupplierModel();
        $suppliers = $suppliersModel->supplierList();
        if ($products){
            return view('home/product.home',[
                'products'=>$products,
                'tab_menu' => $this->tab_menu,
                'skuId' => $skuId,
                'name' => $name,
                'per_page' => $this->per_page,
                'suppliers' => $suppliers,
                'supplier_id' => $supplier_id,
            ]);
        }
    }

    /*
    * 状态
    */
//    public function saasType(Request $request, $id)
//    {
//        $ok = ProductsModel::saasType($id, 1);
//        return back()->withInput();
//    }
//
//    public function unSaasType(Request $request, $id)
//    {
//        $ok = ProductsModel::saasType($id, 0);
//        return back()->withInput();
//    }

    /**
     * 详情
     */
    public function details(Request $request)
    {
        $id = (int)$request->input('id');

        $category = new CategoriesModel();
        $lists = $category->lists();  // 分类列表

        // 供应商列表
        $suppliersModel = new SupplierModel();
        $suppliers = $suppliersModel->supplierList();

        $product = ProductsModel::find($id);

        //获取七牛上传token
        $token = QiniuApi::upToken();

        $user_id = Auth::user()->id;

        //获取商品的图片
        $assets = AssetsModel::where(['target_id' => $id,'type' => 1])->get();
        //获取商品详情的图片
        $assetsProductDetails = AssetsModel::where(['target_id' => $id,'type' => 22])->get();

        $random = [];
        for ($i = 0; $i<2; $i++) {
            $random[] = uniqid();  //获取唯一字符串
        }

        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if(!Cookie::has('product_back_url')){
            Cookie::queue('product_back_url', $url, 60);  // 设置修改完成转跳url
        }
        return view('home/product.details', [
            'product' => $product,
            'lists' => $lists,
            'suppliers' => $suppliers,
            'token' => $token,
            'user_id' => $user_id,
            'assets' => $assets,
            'assetsProductDetails' => $assetsProductDetails,
            'url' => $url,
            'random' => $random,
            'name' => ''
        ]);
    }

    /**
     *生成虚拟库存
     */
    public function virtualInventory(Request $request)
    {
        $sku_id = $request->input('id');
        $storage_id = config('constant.storage_id');
        $sku_number = config('constant.sku_count');
        //获取sku信息
        $product_sku = ProductsSkuModel::where('id' , $sku_id)->first();
        if(!$product_sku){
            return ajax_json(0,'没有找到sku');
        }
        // 增加商品，SKU 总库存
        $skuModel = new ProductsSkuModel();
        if(!$skuModel->addInventory($sku_id, $sku_number)){
            return ajax_json(0 , '虚拟库存变更数量失败');
        }
        //查看虚拟库存根据sku_id,仓库id，部门是否创建过
        $storage_sku_count = StorageSkuCountModel::where('sku_id' , $sku_id)->where('storage_id' , $storage_id)->where('department' , 1)->first();
        //创建过变更为10000
        if($storage_sku_count){
            $storage_sku_count->count = $sku_number + $storage_sku_count->count;
            if($storage_sku_count->save()){
                return ajax_json(1 , '该虚拟库存已经存在，补充完毕');
            }else{
                return ajax_json(0 , '虚拟库存变更数量失败');
            }
        //没创建时重新生成创建
        }else{
            $storage_skuCount = new StorageSkuCountModel();
            $storage_skuCount->sku_id = $sku_id;
            $storage_skuCount->storage_id = $storage_id;
            $storage_skuCount->department = 1;
            $storage_skuCount->count = $sku_number;
            $storage_skuCount->product_id = $product_sku->product_id;
            $storage_skuCount->product_number = $product_sku->product_number;
            if($storage_skuCount->save()){
                return ajax_json(1 , '虚拟库存生成成功');
            }else{
                return ajax_json(0 , '虚拟库存生成失败');
            }
        }
    }
}
