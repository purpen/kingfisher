<?php

namespace App\Http\Controllers\Fiu;

use App\Helper\JPush;
use App\Http\Controllers\Controller;
use App\Models\ProductSkuRelation;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\ProductUserRelation;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 分发saas商品管理页面
 *
 * Class SaasProductController
 * @package App\Http\Controllers\Home
 */
class SaasProductController extends Controller
{
    /**
     * saas 商品列表页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lists(Request $request)
    {
        $this->tab_menu = 'default';
        $this->per_page = $request->input('per_page', $this->per_page);

        $name = '';

        $products = ProductsModel::orderBy('saas_type', 'desc')->paginate($this->per_page);

        return view("fiu/saas.productList", [
            'products' => $products,
            'tab_menu' => $this->tab_menu,
            'name' => $name,
            'per_page' => $this->per_page,
        ]);
    }

    /*
    * 状态saas 商品开放
    */
    public function ajaxSaasType(Request $request)
    {
        $product = ProductUserRelation::where(['product_id' => $request->product_id, 'user_id' => 0])->first();
        if(!$product){
            return ajax_json(0, '商品未设置价格！');
        }
        $skus = ProductsSkuModel::select('id')->where(['product_id' => $request->product_id])->get();
        foreach ($skus as $sku){
            $saas_sku = ProductSkuRelation::where(['sku_id' => $sku->id, 'user_id' => 0])->first();
            if(!$saas_sku){
                return ajax_json(0, '商品的sku未设置价格！');
            }
        }

        $ok = ProductsModel::saasType($request->product_id, 1);
        return ajax_json(1, 'ok');
    }

    /**
     *  商品关闭开放
     *
     * @param Request $request
     * @param $id
     * @return string
     */
    public function ajaxUnSaasType(Request $request)
    {
        $ok = ProductsModel::saasType($request->product_id, 0);
        return ajax_json(1, 'ok');
    }

    // 商品详情
    public function info(Request $request)
    {
        $product_id = $request->input('id');
        //商品信息
        if (!$product = ProductsModel::find($product_id)) {
            return view("errors.403");
        }
        // 用户列表
        $user_list = UserModel::where('status', 1)->get();

        $product_user_s = ProductUserRelation::with('ProductSkuRelation', 'user', 'ProductsModel')
            ->where(['product_id' => $product_id])
            ->where('user_id', '!=', 0)
            ->get();

        return view("fiu/saas.info", [
            'product' => $product,
            'user_list' => $user_list,
            'product_user_s' => $product_user_s,
        ]);
    }

    /**
     * 关联商品和用户
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function ajaxSetCheck(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $user_id = (int)$request->input('user_id');

        try {
            DB::beginTransaction();
            $product_user_relation = ProductUserRelation::firstOrCreate([
                'product_id' => $product_id,
                'user_id' => $user_id,
            ]);

            $skus = ProductsSkuModel::where('product_id', $product_id)->get();

            foreach ($skus as $v) {
                ProductSkuRelation::firstOrCreate([
                    'product_user_relation_id' => $product_user_relation->id,
                    'sku_id' => $v->id,
                    'user_id' => $product_user_relation->user_id,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return view("errors.503");
        }

        DB::commit();

        // 向当前用户推送消息
        $data = [
            'platform' => 'all',
            'alias' => [(string)$user_id],
            'extras' => [
                'info_id' => $product_id,
                'info_type' => 1,
            ],
        ];
        JPush::send('Fiu向您推荐了新商品', $data);

        return redirect()->action('Fiu\SaasProductController@info', ['id' => $product_id]);
    }

    /**
     * 取消商品和用户的关联
     *
     * @param Request $request
     * @return string
     */
    public function ajaxDelete(Request $request)
    {
        // 关联信息的ID
        $id = (int)$request->input('id');
        DB::beginTransaction();
        try {
            ProductUserRelation::destroy($id);
            ProductSkuRelation::where('product_user_relation_id', $id)->delete();

        } catch (\Exception $e) {
            DB::rollBack();
            return ajax_json(0, 'error');
        }
        DB::commit();

        return ajax_json(1, 'ok');
    }

    /**
     * 获取商品价格信息
     *
     * @param Request $request
     * @return string
     */
    public function getProduct(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:product_user_relation,id',
        ]);
        $id = $request->input('id');
        $ProductUserRelation = ProductUserRelation::find($id);

        return ajax_json(1, 'ok', ['price' => $ProductUserRelation->price]);

    }

    /**
     * 编辑分销商看到的商品售价
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setProduct(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:product_user_relation,id',
            'price' => 'numeric',
        ]);

        $id = $request->input('id');
        $price = $request->input('price');

        $ProductUserRelation = ProductUserRelation::find($id);
        if (!empty($price)) {
            $ProductUserRelation->price = $price;
        }
        $ProductUserRelation->save();

        return redirect()->action('Fiu\SaasProductController@info', ['id' => $ProductUserRelation->product_id]);
    }


    /**
     * 获取sku信息
     *
     * @param Request $request
     * @return string
     */
    public function getSku(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:product_sku_relation,id',
        ]);

        $id = $request->input('id');
        $ProductSkuRelation = ProductSkuRelation::find($id);

        return ajax_json(1, 'ok', ['price' => $ProductSkuRelation->price, 'quantity' => $ProductSkuRelation->quantity]);
    }

    /**
     * 编辑分销商看到的SKU售价
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setSku(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|integer',
            'id' => 'required|exists:product_sku_relation,id',
            'price' => 'numeric',
            'quantity' => 'integer',
        ]);

        $id = $request->input('id');
        $price = $request->input('price');
        $quantity = $request->input('quantity');

        $ProductSkuRelation = ProductSkuRelation::find($id);
        if (!empty($price)) {
            $ProductSkuRelation->price = $price;
        }

        if (!empty($quantity)) {
            $ProductSkuRelation->quantity = $quantity;
        }

        $ProductSkuRelation->save();

        //修改对应product库存
        $ProductSkuRelation->skuQuantityChange($id);

        return redirect()->action('Fiu\SaasProductController@info', ['id' => $request->product_id]);
    }


    //编辑saas分发平台商品基础信息
    public function ajaxSetSaasProduct(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|integer',
            'price' => 'numeric',
        ]);

        $saas_product = ProductUserRelation::firstOrCreate(['product_id' => $request->product_id, 'user_id' => 0]);

        $saas_product->price = $request->price;
        if($saas_product->save()){
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'设置失败！');
        }


    }

    //获取fiu商品基础价格
    public function ajaxGetSaasProduct(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|integer',
        ]);

        $product = ProductUserRelation::where(['product_id' => $request->product_id, 'user_id' => 0])->first();

        if (!$product) {
            return ajax_json(1, 'ok');
        } else {
            return ajax_json(1, 'ok', ['price' => $product->price]);
        }
    }

    //编辑saas分发平台sku基础信息
    public function ajaxSetSaasSku(Request $request)
    {
        $this->validate($request, [
            'sku_id' => 'required|integer',
            'price' => 'numeric',
        ]);

        $saas_sku = ProductSkuRelation::firstOrCreate(['sku_id' => $request->sku_id, 'user_id' => 0]);
        $saas_sku->price = $request->price;

        if($saas_sku->save()){
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'设置失败！');
        }
    }

    //    获取fiu中sku的基础信息
    public function ajaxGetSaasSku(Request $request)
    {
        $this->validate($request, [
            'sku_id' => 'required|integer',
        ]);

        $saas_sku = ProductSkuRelation::where(['sku_id' => $request->sku_id, 'user_id' => 0])->first();

        if (!$saas_sku) {
            return ajax_json(1, 'ok');
        } else {
            return ajax_json(1, 'ok', ['price' => $saas_sku->price]);
        }
    }

}