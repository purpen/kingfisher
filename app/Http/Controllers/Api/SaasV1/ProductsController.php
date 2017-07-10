<?php

namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\ProductListsTransformer;
use App\Http\SaasTransformers\ProductsTransformer;
use App\Models\ProductUserRelation;
use Illuminate\Http\Request;

class ProductsController extends BaseController
{
    /**
     * @api {get} /saasApi/product/recommendList 推荐的商品列表
     * @apiVersion 1.0.0
     * @apiName Products lists
     * @apiGroup Products
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
     * {
        "data": [
            {
                "id": 2,
                "product_id": 60,                   // 商品ID
                "number": "116110418454",           // 商品编号
                "name": "Artiart可爱便携小鸟刀水果刀",    // 商品名称
                "price": "200.00",                      // 商品价格
                "inventory": 1,                         // 库存
                "image": "http://erp.me/images/default/erp_product.png",
                "status": 1                          // 状态：0.未合作；1.已合作
            }
        ],
        "meta": {
            "message": "Success.",
            "status_code": 200,
            "pagination": {
                "total": 1,
                "count": 1,
                "per_page": 10,
                "current_page": 1,
                "total_pages": 1,
                "links": []
            }
        }
    }
     */
    public function recommendList(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $lists = ProductUserRelation::with('ProductsModel')
            ->where(['user_id' => $this->auth_user_id])
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($lists, new ProductListsTransformer)->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/product/info 商品详情
     * @apiVersion 1.0.0
     * @apiName Products info
     * @apiGroup Products
     *
     * @apiParam {integer} product_id 商品ID
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     {
        "data": {
            "id": 2,
            "product_id": 60,                           // 商品ID
            "number": "116110418454",                   // 商品编号
            "category": "智能硬件",                         //分类
            "name": "Artiart可爱便携小鸟刀水果刀",            //商品名称
            "short_name": "Artiart可爱便携小鸟刀水果刀",      //短名称
            "price": "200.00",                              // 价格
            "weight": "0.00",                               // 重量
            "summary": "",                                  // 备注
            "inventory": 1,                                 // 库存
            "image": "http://erp.me/images/default/erp_product.png",
            "skus": [
                    {
                        "sku_id": 42,
                        "number": "116110436487",
                        "mode": "黑色",                     // 型号
                        "price": "123.00"                   // 价格
                    },
            ]
        },
        "meta": {
        "message": "Success.",
        "status_code": 200
        }
    }
     **/
    public function info(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $user_id = $this->auth_user_id;

        $info = ProductUserRelation::where(['user_id' => $user_id, 'product_id' => $product_id])->first();

        if(!$info){
            return $this->response->array(ApiHelper::error('not found', 404));
        }

        return $this->response->item($info, new ProductsTransformer)->setMeta(ApiHelper::meta());
    }

    /**
     * @api {post} /saasApi/product/trueCooperate 确认合作商品
     * @apiVersion 1.0.0
     * @apiName Products trueCooperate
     * @apiGroup Products
     *
     * @apiParam {integer} product_id 商品ID
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     *   "meta": {
            "message": "Success.",
            "status_code": 200
            }
     * }
     */
    public function trueCooperate(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $user_id = $this->auth_user_id;

        $ProductUserRelation = ProductUserRelation::where(['user_id' => $user_id, 'product_id' => $product_id])->first();

        if(!$ProductUserRelation){
            return $this->response->array(ApiHelper::error('not found', 404));
        }

        $ProductUserRelation->status = 1;
        $ProductUserRelation->save();

        return $this->response->array(ApiHelper::success());
    }

    /**
     * @api {get} /saasApi/product/cooperateProductLists 合作的商品列表
     * @apiVersion 1.0.0
     * @apiName Products cooperateProductLists
     * @apiGroup Products
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
     * {
    "data": [
        {
        "id": 2,
        "product_id": 60,                   // 商品ID
        "number": "116110418454",           // 商品编号
        "name": "Artiart可爱便携小鸟刀水果刀",    // 商品名称
        "price": "200.00",                      // 商品价格
        "inventory": 1,                         // 库存
        "image": "http://erp.me/images/default/erp_product.png"
        }
        ],
        "meta": {
            "message": "Success.",
            "status_code": 200,
            "pagination": {
                "total": 1,
                "count": 1,
                "per_page": 10,
                "current_page": 1,
                "total_pages": 1,
                "links": []
            }
        }
    }
     */
    public function cooperateProductLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $lists = ProductUserRelation::with('ProductsModel')
            ->where(['user_id' => $this->auth_user_id])
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($lists, new ProductListsTransformer)->setMeta(ApiHelper::meta());
    }

}
