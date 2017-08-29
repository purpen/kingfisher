<?php

namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\CooperateProductListsTransformer;
use App\Http\SaasTransformers\OpenProductListTransformer;
use App\Http\SaasTransformers\ProductListsTransformer;
use App\Models\CooperationRelation;
use App\Models\ProductsModel;
use App\Models\ProductUserRelation;
use Illuminate\Http\Request;

class ProductsController extends BaseController
{
    /**
     * @api {get} /saasApi/product/lists 商品库列表
     * @apiVersion 1.0.0
     * @apiName Products lists
     * @apiGroup Products
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
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
     *      "status": 1                          // 状态：0.未合作；1.已合作
     *      }
     * ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "pagination": {
     *              "total": 1,
     *              "count": 1,
     *              "per_page": 10,
     *              "current_page": 1,
     *              "total_pages": 1,
     *              "links": []
     *              }
     *          }
     * }
     */
    public function lists(Request $request)
    {
        $this->per_page = $request->input('per_page', $this->per_page);

        // 私有的商品ID 数组
        $id_array = ProductUserRelation::relationProductsIdArray();
        $products = ProductsModel::where('saas_type', 1)
            ->whereNotIn('id', $id_array)
            ->orderBy('id', 'desc')
            ->paginate($this->per_page);

        return $this->response->paginator($products, new OpenProductListTransformer($this->auth_user_id))->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /saasApi/product/recommendList 推荐的商品列表
     * @apiVersion 1.0.0
     * @apiName Products recommendList
     * @apiGroup Products
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     * {
     * "id": 2,
     * "product_id": 60,                   // 商品ID
     * "number": "116110418454",           // 商品编号
     * "name": "Artiart可爱便携小鸟刀水果刀",    // 商品名称
     * "price": "200.00",                      // 商品价格
     * "inventory": 1,                         // 库存
     * "image": "http://erp.me/images/default/erp_product.png",
     * "status": 1                          // 状态：0.未合作；1.已合作
     * }
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200,
     * "pagination": {
     * "total": 1,
     * "count": 1,
     * "per_page": 10,
     * "current_page": 1,
     * "total_pages": 1,
     * "links": []
     * }
     * }
     * }
     */
    public function recommendList(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $lists = ProductUserRelation::with('ProductsModel')
            ->where(['user_id' => $this->auth_user_id])
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($lists, new ProductListsTransformer($this->auth_user_id))->setMeta(ApiHelper::meta());
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
     * {
     * "data": {
     * "id": 2,
     * "product_id": 60,                           // 商品ID
     * "number": "116110418454",                   // 商品编号
     * "category": "智能硬件",                         //分类
     * "name": "Artiart可爱便携小鸟刀水果刀",            //商品名称
     * "short_name": "Artiart可爱便携小鸟刀水果刀",      //短名称
     * "price": "200.00",                              // 价格
     * "weight": "0.00",                               // 重量
     * "summary": "",                                  // 备注
     * "inventory": 1,                                 // 库存
     * "image": "http://erp.me/images/default/erp_product.png",
     * "status": 1                          // 状态：0.未合作；1.已合作
     * "slaes_number": 23                           // 销售数量
     * "skus": [
     * {
     * "sku_id": 42,
     * "number": "116110436487",
     * "mode": "黑色",                     // 型号
     * "price": "123.00"                   // 价格
     * "image": "http://erp.me/images/default/erp_product1.png",
     * "inventory": 0                               // 库存
     * },
     * ]
     * },
     * "meta": {
     * "message": "Success.",
     * "status_code": 200
     * }
     * }
     **/
    public function info(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $user_id = $this->auth_user_id;

        $productUserRelation = new ProductUserRelation();
        $info = $productUserRelation->productInfo($user_id, $product_id);
        if (!$info) {
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        return $this->response->array(ApiHelper::success('Success', 200, $info));
    }


    /**
     * @api {post} /saasApi/product/trueCooperate 确认合作商品
     * @apiVersion 1.0.0
     * @apiName Products trueCooperate
     * @apiGroup Products
     *
     * @apiParam {bool} status 状态：0：取消合作；1.确认合作；
     * @apiParam {integer} product_id 商品ID
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     *   "meta": {
     *          "message": "Success.",
     *          "status_code": 200
     *      },
     *   "data":{
     *      "status": 1,
     *   }
     * }
     */
    public function trueCooperate(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $status = (empty($request->input('status'))) ? 0 : 1;
        $user_id = $this->auth_user_id;

        $product = ProductsModel::where('saas_type', 1)
            ->where('id', $product_id)
            ->count();
        if (!$product) {
            return $this->response->array(ApiHelper::error("商品不存在", 404));
        }

        if ($status) {   // 添加合作
            if (!CooperationRelation::addCooperation($user_id, $product_id)) {
                return $this->response->array(ApiHelper::error("error", 500));
            }
            $data = ['status' => 1];
        } else {        // 删除合作
            if (!CooperationRelation::deleteCooperation($user_id, $product_id)) {
                return $this->response->array(ApiHelper::error("error", 500));
            }
            $data = ['status' => 0];
        }

        return $this->response->array(ApiHelper::success('Success.', 200, $data));
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
     * "data": [
     * {
     * "id": 2,
     * "product_id": 60,                   // 商品ID
     * "number": "116110418454",           // 商品编号
     * "name": "Artiart可爱便携小鸟刀水果刀",    // 商品名称
     * "price": "200.00",                      // 商品价格
     * "inventory": 1,                         // 库存
     * "image": "http://erp.me/images/default/erp_product.png"
     * }
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200,
     * "pagination": {
     * "total": 1,
     * "count": 1,
     * "per_page": 10,
     * "current_page": 1,
     * "total_pages": 1,
     * "links": []
     * }
     * }
     * }
     */
    public function cooperateProductLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;

        $cooperation_product = CooperationRelation::select(['id', 'product_id'])
            ->where('user_id', $this->auth_user_id)
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($cooperation_product, new CooperateProductListsTransformer($this->auth_user_id))->setMeta(ApiHelper::meta());
    }

}
