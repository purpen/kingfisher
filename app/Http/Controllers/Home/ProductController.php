<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Http\Controllers\Common\AssetController;
use App\Models\AssetsModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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
        
        return $this->display_tab_list();
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
            $products = ProductsModel::orderBy('id','desc')->paginate(20);
        }else{
            $products = ProductsModel::where('status',$status)->orderBy('id','desc')->paginate(20);
        }

        $skus = ProductsSkuModel::orderBy('id','desc')->get();
        $skuId = [];
        foreach($skus as $sku){
            $skuId[] = $sku->product_id;
        }
        return view("home/product.home", [
            'lists' => $lists,
            'products' => $products,
            'tab_menu' => $this->tab_menu,
            'skuId' => $skuId,
            'name' => $name
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

        /*获取商品编码*/
        $number = $this->uniqueNumber();
        
        $this->tab_menu = 'default';
        
        return view('home/product.create',['lists' => $lists,'random' => $random,'suppliers' => $suppliers,'user_id' => $user_id,'token' => $token,'number' => $number, 'tab_menu' => $this->tab_menu,'name' => '']);
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

        $random = [];
        for ($i = 0; $i<2; $i++) {
            $random[] = uniqid();  //获取唯一字符串
        }

        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if(!Cookie::has('product_back_url')){
            Cookie::queue('product_back_url', $url, 60);  // 设置修改完成转跳url
        }
        
        $this->tab_menu = 'default';
        
        return view('home/product.edit', [
            'product' => $product,
            'lists' => $lists,
            'suppliers' => $suppliers,
            'token' => $token,
            'user_id' => $user_id,
            'assets' => $assets,
            'url' => $url,
            'random' => $random,
            'tab_menu' => $this->tab_menu,
            'name' => ''
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
        $id = (int)$request->input('product_id');
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
        $name = $request->input('search');
        $products = ProductsModel::where('number','like','%'.$name.'%')->orWhere('title','like','%'.$name.'%')->paginate(20);
        $skus = ProductsSkuModel::orderBy('id','desc')->get();
        $skuId = [];
        foreach($skus as $sku){
            $skuId[] = $sku->product_id;
        }
        if ($products){
            return view('home/product.home',[
                'products'=>$products,
                'tab_menu' => $this->tab_menu,
                'skuId' => $skuId,
                'name' => $name
            ]);
        }
    }
    
}
