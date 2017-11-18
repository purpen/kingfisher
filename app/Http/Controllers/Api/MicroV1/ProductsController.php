<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Http\MicroTransformers\ProductListTransformer;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class ProductsController extends BaseController
{
    /**
     * @api {get} /MicroApi/product/lists 商品列表
     * @apiVersion 1.0.0
     * @apiName Products lists
     * @apiGroup Products
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                            // 商品ID
     *      "product_id": 60,                   // 商品ID
     *      "number": "116110418454",           // 商品编号
     *      "name": "Artiart可爱便携小鸟刀水果刀",    // 商品名称
     *      "price": "200.00",                      // 商品价格
     *      "inventory": 1,                         // 库存
     *      "image": "http://erp.me/images/default/erp_product.png",
     *      }
     * ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "pagination": {
     *           "total": 705,
     *           "count": 15,
     *           "per_page": 15,
     *           "current_page": 1,
     *           "total_pages": 47,
     *           "links": {
     *           "next": "http://erp.me/MicroApi/product/lists?page=2"
     *           }
     *       }
     *   }
     * }
     */
    public function lists(Request $request)
    {
        $this->per_page = $request->input('per_page', $this->per_page);

        $products = ProductsModel::orderBy('id', 'desc')
            ->paginate($this->per_page);

        return $this->response->paginator($products, new ProductListTransformer($this->auth_user_id))->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /MicroApi/product 商品详情
     * @apiVersion 1.0.0
     * @apiName Products product
     * @apiGroup Products
     *
     * @apiParam {integer} product_id 商品id
     * @apiParam {string} token token
     */
    public function product(Request $request)
    {
        $product_id = $request->input('product_id');

    }



}
