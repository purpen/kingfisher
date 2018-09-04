<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\CategoryTransformer;
use App\Http\DealerTransformers\FollowListTransformer;
use App\Http\DealerTransformers\OpenProductListTransformer;
use App\Http\DealerTransformers\ProductListTransformer;
use App\Http\DealerTransformers\ProductTransformer;
use App\Model\Category;
use App\Models\AssetsModel;
use App\Models\CategoriesModel;
use App\Models\ChinaCityModel;
use App\Models\CollectionModel;
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
     * @api {get} /DealerApi/product/lists 商品库列表(暂未使用)
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
     *"product_details"                               //商品图文详情
     * "status": 1                          // 状态：0.未合作；1.已合作
     * "sales_number": 23                           // 销售数量
     * "follows":109                                //此商品被关注数量
     * "skus": [
     * {
     * "sku_id": 42,
     * "number": "116110436487",
     * "mode": "黑色",                     // 型号
     * "price": "123.00"                   // 价格
     * "market_price": "123",               // 市场价格
     * "image": "http://erp.me/images/default/erp_product1.png",
     *  "product_details":  "<p>aaa</p><img src=\"/uploads/ueditor/php/upload/image/20180829/1535523347162632.jpeg\">",
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
        $user_id = $this->auth_user_id;

        $product = ProductsModel::where('id' , $product_id)->first();
        $category = CategoriesModel::where('id',$product->category_id)->where('type',1)->select('title')->first();
        $product->category = $category->title;

        $follow = CollectionModel::where('product_id',$product_id)->get();
        if ($follow){
            $product->follows = count($follow);//已关注数量
        }else{
            $product->follows = 0;//暂未被关注
        }
//        if ($product) {
//            $productS = ProductsSkuModel::where('product_id', $product_id)->select('id')->get();
//            $productSku = $productS->toArray();
//            $productSkus = array_column($productSku, 'id');
//
//            $region = SkuRegionModel::whereIn('sku_id', $productSkus)->get();//获取价格区间
//            if (count($region) > 0) {
//                $product['sku_region'] = $region->toArray();
//            }
//        }
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
     *     "product_details":  "http://erp.me/images/default/erp_product1.png",
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
     *           "next": "http://www.work.com/DealerApi/product/lists?page=2"
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
     * @api {get} /DealerApi/product/categories 经销商能看到的商品分类列表
     * @apiVersion 1.0.0
     * @apiName Products categories
     * @apiGroup Products
     *
     * @apiParam {string} token token
     */
    public function categories()
    {
        $category = DistributorModel::where('user_id', $this->auth_user_id)->select('category_id')->first();
        //商品分类
        $categorys = explode(',',$category['category_id']);
        $category = CategoriesModel::whereIn('id',$categorys)->select('id','title')->get();

        return $this->response()->collection($category, new CategoryTransformer())->setMeta(ApiHelper::meta());
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
     * @apiParam {string} categories_id  商品分类ID 0代表所有 其他正常
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
     * "image": "http://www.work.com/images/default/erp_product.png",  //商品图
     * "product_details":  "http://www.work.com/images/default/erp_product1.png", //商品详情介绍图
     * "categories"：  //分类名称
     * "follow"：  //是否被关注  1.已关注 0.未关注
     * }
     * ],
     * "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "pagination": {
     *           "total": 705,
     *           "count": 15,
     *           "per_page": 15,
     *           "current_page": 1,
     *           "total_pages": 47,
     *           "links": {
     *           "next": "http://www.work.com/DealerApi/product/recommendList?page=2"
     *           }
     * }
     */

    public function recommendList(Request $request)
    {
        $user_id = $this->auth_user_id;
        $categories_id = $request->input('categories_id');

        $status = DistributorModel::where('user_id', $this->auth_user_id)->select('status')->first();
        if ($status['status'] != 2) {
            return $this->response->array(ApiHelper::error('审核未通过暂时无法查看商品', 403));
        }
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $province = DistributorModel::where('user_id', $this->auth_user_id)->select('province_id')->first();
        $authorization = DistributorModel::where('user_id', $this->auth_user_id)->select('authorization_id')->first();
        $category = DistributorModel::where('user_id', $this->auth_user_id)->select('category_id')->first();
//        授权条件
        $authorizations = $authorization['authorization_id'];
        $arr = explode(",", $authorizations);
        $len = count($arr);

        for ($i = 0; $i < $len; $i++) {
            $arr[$i] = ',' . $arr[$i] . ',';
        }
        $author = implode("|", $arr);

//        地域分类
        $provin = $province['province_id'];
        $provint_arr = explode(",", $provin);
        $num = count($provint_arr);

        for ($j = 0; $j < $num; $j++) {
            $provint_arr[$j] = ',' . $provint_arr[$j] . ',';
        }
        $provinces = implode("|", $provint_arr);

        //商品分类
        $categorys = explode(',',$category['category_id']);

//        if (count($author) > 0 && count($categorys) > 0 && count($provinces) > 0) {
//            $products = DB::select("select * from products  where concat(',',authorization_id,',') regexp concat('$author') AND category_id IN(SELECT category_id FROM distributor WHERE user_id=$user_id) AND concat(',',region_id,',') regexp concat('$provinces')");

        if ($categories_id == 0) {
//            $products = DB::table('products')
            $products = ProductsModel::
                where('status', '=', 2)
                ->whereNotNull(DB::raw("concat(',',region_id,',') regexp concat('$provinces')"))
                ->whereIn('category_id', $categorys)
                ->whereNotNull(DB::raw("concat(',',authorization_id,',') regexp concat('$author')"))
                ->orderBy('id', 'desc')
                ->paginate($per_page);
        }else{
//            $products = DB::table('products')
            $products = ProductsModel::
                where('status', '=', 2)
                ->where('category_id','=',$categories_id)
                ->whereNotNull(DB::raw("concat(',',region_id,',') regexp concat('$provinces')"))
//                ->whereIn('category_id', $categorys)
                ->whereNotNull(DB::raw("concat(',',authorization_id,',') regexp concat('$author')"))
                ->orderBy('id', 'desc')
                ->groupBy('category_id')
                ->paginate($per_page);
        }
        foreach ($products as $key=>$value){
            $categorys = CategoriesModel::where('id',$value->category_id)->where('type',1)->select('title')->first();
            $follow = CollectionModel::where('product_id',$value->id)->where('user_id',$user_id)->first();
            $value->categories = $categorys->title;
            if ($follow){
                $value->follow = 1;//已关注
            }else{
                $value->follow = 0;//未关注
            }
        }

            if (count($products) > 0) {
//            $productImg = new ProductsModel();
//                foreach ($products as $k => $v) {
//                    $v->product_details = $productImg->detial_img;//商品详情介绍图
////                    $productS = ProductsSkuModel::where('product_id', $v->id)->get();
////                    foreach ($productS as $value) {
//                       $v->image = $productImg->first_img;//封面图
//
////                    }
//                }
                return $this->response->paginator($products, new ProductListTransformer())->setMeta(ApiHelper::meta());
            }else{
                return $this->response->array(ApiHelper::error('暂无匹配数据！', 401));
            }

}


    /**
     * @api {post} /DealerApi/product/follow 关注商品
     * @apiVersion 1.0.0
     * @apiName Products follow
     * @apiGroup Products
     *
     * @apiParam {integer} product_id 商品id
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     * {
     * "id": 2,
     * "product_id": 60,                   // 商品ID
     * }
     * ],
     * "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           }
     * }
     */

    public function follow(Request $request)
    {
        $collection = new CollectionModel();

        $collections = CollectionModel::where('user_id','=',$this->auth_user_id)->where('product_id','=',$request->input('product_id'))->get();
        if ($collections){
            return $this->response->array(ApiHelper::error('已经收藏过了哦~', 403));
        }
        $collection->user_id = $this->auth_user_id;
        $collection->product_id = $request->input('product_id');
        $res = $collection->save();
        if ($res){
            return $this->response->array(ApiHelper::success('添加成功', 200, compact('token')));
        } else {
            return $this->response->array(ApiHelper::error('添加失败，请重试!', 412));
        }
    }


    /**
     * @api {get} /DealerApi/product/followList 关注的商品列表
     * @apiVersion 1.0.0
     * @apiName Products followList
     * @apiGroup Products
     *
     * @apiParam {integer} user_id 用户id
     * @apiParam {string} token token
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     * {
     * "id": 2,
     * "product_id": 60,                   // 商品ID
     * "number": "116110418454",           // 商品编号
     * "name": "Artiart可爱便携小鸟刀水果刀",    // 商品名称
     * "price": "200.00",                      // 商品价格
     * "image": "http://erp.me/images/default/erp_product.png",
     * }
     * ],
     * "meta": {
     *          "pagination": {
     *           "total": 705,
     *           "count": 15,
     *           "per_page": 15,
     *           "current_page": 1,
     *           "total_pages": 47,
     *           "links": {
     *           "next": "http://www.work.com/DealerApi/product/followList?page=2"
     * }
     * }
     */

    public function followList(Request $request)
    {
        $user_id = $this->auth_user_id;
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $followList = CollectionModel::where('user_id',$user_id)->select('product_id')->get();
        if (!$followList) {
            return $this->response->array(ApiHelper::error('您还没有关注的商品！', 403));
        }

        $product_ids = array_column($followList->toArray(),'product_id');
        $products = DB::table('products')
            ->whereIn('id',$product_ids)
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        if (count($products)>0) {
            return $this->response->paginator($products, new FollowListTransformer())->setMeta(ApiHelper::meta());
        }else{
            return $this->response->array(ApiHelper::error('暂无数据！', 401));
        }
    }

    /**
     * @api {post} /DealerApi/product/notFollow 取消关注商品
     * @apiVersion 1.0.0
     * @apiName Products notFollow
     * @apiGroup Products
     *
     * @apiParam {integer} user_id   用户id
     * @apiParam {integer} product_id 商品id
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     * {
     * "id": 2,
     * "product_id": 60,        // 商品ID
     * "user_id": 60,         // 用户ID
     * }
     * ],
     * "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           }
     * }
     */

    public function notFollow(Request $request)
    {
        $product_id = $request->input('product_id');
        $collection = CollectionModel::where('product_id',$product_id)->where('user_id',$this->auth_user_id)->first();
        if (!$collection){
            return $this->response->array(ApiHelper::error('该商品您没有关注！', 403));
        }else{
            $collection->destroy($collection->id);
            return $this->response->array(ApiHelper::success());
        }

    }

}













