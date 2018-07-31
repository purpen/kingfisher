<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\OpenProductListTransformer;
use App\Http\DealerTransformers\ProductListTransformer;
use App\Http\DealerTransformers\ProductTransformer;
use App\Models\AssetsModel;
use App\Models\CategoriesModel;
use App\Models\DistributorModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\ProductUserRelation;
use App\Models\SkuRegionModel;
use App\Models\UserProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends BaseController
{
    /**
     * @api {get} /DealerApi/product/list 商品库列表
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
        $products = ProductsModel::where('status', 2)
            ->orderBy('id', 'desc')
            ->paginate($this->per_page);

        return $this->response->paginator($products, new OpenProductListTransformer())->setMeta(ApiHelper::meta());
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
     * "sales_number": 23                           // 销售数量
     * "skus": [
     * {
     * "sku_id": 42,
     * "number": "116110436487",
     * "mode": "黑色",                     // 型号
     * "price": "123.00"                   // 价格
     * "market_price": "123",               // 市场价格
     * "image": "http://erp.me/images/default/erp_product1.png",
     * "inventory": 0                               // 库存
     *
     *  "sku_region": [
     *      {
     *      "id": 2,                            // ID
     *      "sku_id": 60,                   // skuID
     *      "user_id": "1",           // 用户id
     *      "min": "1",    // 下限数量
     *      "max": "50",    // 上限数量
     *      "sell_price": "200.00",                      // 商品价格
     *      }
     * ],
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
//        $product_id = 10;
        $user_id = $this->auth_user_id;

        $product = ProductsModel::where('id' , $product_id)->first();
        $category = CategoriesModel::where('id',$product->id)->select('title')->first();
        $product['category'] = $category->title;
//
        if ($product) {
            $productS = ProductsSkuModel::where('product_id', $product_id)->select('id')->get();
            $productSku = $productS->toArray();
            $productSkus = array_column($productSku, 'id');

            $region = SkuRegionModel::whereIn('sku_id', $productSkus)->get();//获取价格区间
            if (count($region) > 0) {
                $product['sku_region'] = $region->toArray();
            }
        }
        if (!$product) {
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        return $this->response->item($product, new ProductTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /DealerApi/product/search 商品搜索
     * @apiVersion 1.0.0
     * @apiName Products search
     * @apiGroup Products
     *
     * @apiParam {string} name 商品名称
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                            // ID
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
     *           "next": "http://erp.me/DealerApi/product/lists?page=2"
     *           }
     *       }
     *   }
     * }
     */


    public function search(Request $request){
        $name = $request->input('name');
        $this->per_page = $request->input('per_page', $this->per_page);

        $products = ProductsModel::where('title' , 'like', '%'.$name.'%')->where('status',2)->orderBy('id', 'desc')
            ->paginate($this->per_page);
        return $this->response->paginator($products, new ProductListTransformer())->setMeta(ApiHelper::meta());


    }

    /**
     * @api {get} /DealerApi/product/recommendList 推荐的商品列表
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

    public function recommendList(Request $request){
        $user_id = $this->auth_user_id;
//        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $province = DistributorModel::where('user_id',$user_id)->select('province_id')->first();
        $authorization = DistributorModel::where('user_id',$user_id)->select('authorization_id')->first();
        $category = DistributorModel::where('user_id',$user_id)->select('category_id')->first();
        $provinces=$province['province_id'];
        $authorizations = $authorization['authorization_id'];
        $categorys = $category['category_id'];
        $str = $authorizations;
        $arr = explode(",",$str);
        $len=count($arr);

        for($i=0;$i<$len;$i++){
            $arr[$i] = ','.$arr[$i].',';
        }
        $author = implode("|",$arr);
//        $html = "";
//        foreach($authorization as $v){
//            $html .= $v['authorization_id'].",";
//        }
//        $array = explode(',',implode(",",array_unique(explode(",",substr($html,0,-1)))));

        $product = DB::select("select * from products  where concat(',',authorization_id,',') regexp concat('$author') AND category_id = $categorys AND region_id = $provinces order by id DESC");

        $collection = collect($product);
        return $this->response->item($collection, new ProductListTransformer())->setMeta(ApiHelper::meta());
//        return $this->response->collection($collection, new ProductListTransformer);
    }

}













