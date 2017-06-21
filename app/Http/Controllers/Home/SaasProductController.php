<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;

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

        $products = ProductsModel::where('status', 2)->orderBy('id','desc')->paginate($this->per_page);

        return view("home/saas.productList", [
            'products' => $products,
            'tab_menu' => $this->tab_menu,
            'name' => $name,
            'per_page' => $this->per_page,
        ]);
    }

    // 商品详情
    public function info()
    {
        return view("home/saas.info");
    }

}