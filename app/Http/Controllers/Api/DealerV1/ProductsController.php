<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\OpenProductListTransformer;
use App\Models\AssetsModel;
use App\Models\ProductsModel;
use App\Models\ProductUserRelation;
use App\Models\UserProductModel;
use Illuminate\Http\Request;

class ProductsController extends BaseController
{
    /**
     * @api {get} /DealerApi/product/lists 商品库列表
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

        // 当前用户不能查看的商品ID数组
        $not_see_product_id_arr = UserProductModel::notSeeProductId($this->auth_user_id);
        $products = ProductsModel::where('saas_type', 1)
            ->whereNotIn('id', $not_see_product_id_arr)
            ->orderBy('id', 'desc')
            ->paginate($this->per_page);

        return $this->response->paginator($products, new OpenProductListTransformer($this->auth_user_id))->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /DealerApi/product/info 商品详情
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
     * "market_price": "123",                           // 市场价格
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
     * "market_price": "123",               // 市场价格
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

        // 当前用户不能查看的商品ID数组
        $not_see_product_id_arr = UserProductModel::notSeeProductId($this->auth_user_id);

        if(in_array($product_id, $not_see_product_id_arr)){
            return $this->response->array(ApiHelper::error('无权限', 403));
        }

        $productUserRelation = new ProductUserRelation();
        $info = $productUserRelation->productInfo($user_id, $product_id);
        $assets = AssetsModel
            ::where(['target_id' => $product_id, 'type' => 15])
            ->orderBy('id','desc')
            ->get();
        if (!$info) {
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        $info['supplier_asset'] = [];
        foreach ($assets as $asset){
            $info['supplier_asset'][] =  $asset->file;
        }
        return $this->response->array(ApiHelper::success('Success', 200, $info));
    }

}