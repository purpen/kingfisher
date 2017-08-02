<?php

namespace App\Http\Controllers\Fiu;

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

        $products = ProductsModel::where('saas_type', 1)->orderBy('id', 'desc')->paginate($this->per_page);

        return view("fiu/saas.productList", [
            'products' => $products,
            'tab_menu' => $this->tab_menu,
            'name' => $name,
            'per_page' => $this->per_page,
        ]);
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
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return view("errors.503");
        }

        DB::commit();

        return redirect()->action('Fiu\SaasProductController@info', ['id' => $product_id]);
    }

    /**
     * 取消分销商和用户的关联
     *
     * @param Request $request
     * @return string
     */
    public function ajaxDelete(Request $request)
    {
        // 关联信息的ID
        $id = (int)$request->input('id');
        DB::beginTransaction();
        try{
            ProductUserRelation::destroy($id);
            ProductSkuRelation::where('product_user_relation_id', $id)->delete();

        }catch (\Exception $e){
            DB::rollBack();
            return ajax_json(0, 'error');
        }
        DB::commit();

        return ajax_json(1, 'ok');
    }

    /**
     * 编辑分销商看到的商品售价和库存
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setProduct(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:product_user_relation,id',
            'price' => 'numeric',
            'stock' => 'integer',
        ]);

        $id = $request->input('id');
        $price = $request->input('price');
        $stock = $request->input('stock');

        $ProductUserRelation = ProductUserRelation::find($id);
        if (!empty($price)) {
            $ProductUserRelation->price = $price;
        }
        if (!empty($stock)) {
            $ProductUserRelation->stock = $stock;
        }
        $ProductUserRelation->save();

        return redirect()->action('Fiu\SaasProductController@info', ['id' => $ProductUserRelation->product_id]);
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
        ]);

        $id = $request->input('id');
        $price = $request->input('price');

        $ProductSkuRelation = ProductSkuRelation::find($id);
        if(!empty($price)){
            $ProductSkuRelation->price = $price;
        }
        $ProductSkuRelation->save();

        return redirect()->action('Fiu\SaasProductController@info', ['id' => $request->product_id]);
    }

}