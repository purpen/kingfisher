<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Models\CollectionModel;
use App\Models\ReceiptModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\SkuRegionModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class CartController extends BaseController
{
    /**
     * @api {get} /DealerApi/cart 我的进货单列表
     * @apiVersion 1.0.0
     * @apiName Cart lists
     * @apiGroup Cart
     * @apiParam {string} status 1:立即购买进入的进货单
     * @apiParam {char} title 大米:搜索时所需参数
     * @apiParam {string} per_page 1:一页多少条数据
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                      // 购物车ID
     *      product_name :"大米",                   商品名称
     *      inventory  :40,                 商品库存数量
     *      market_price    "111",            商品销售价格
     *      cover_url   ：1.img ,              图片url
     *      "product_id": 4456,           // 商品ID
     *      "price": "200.00",            // 商品价格
     *      "mode":颜色：白色 ,                   类型
     *      "number": 1,                       // 购买数量
     *      "status": 3,                  // 状态：3添加，4立即购买
     *      "focus": 1,                  // 状态：1关注，2未关注
     *       "sku_region"[{
     *               min:1, //下限数量
     *              max:2,//上限数量
     *              sell_price:22 //销售价格
     *          }]
     *      }
     *   ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           "data" : $data,
     *          "count":22,
     *       }
     *   }
     * }
     */
    public function lists(Request $request)
    {
        $user_id = $this->auth_user_id;
        $status = $request->input('status') ? $request->input('status') : '';
        $title = $request->input('title') ? $request->input('title') : '';
        $per_page = (int)$request->input('per_page', 20);

        $carts = ReceiptModel::select('receipt.*','p.title')
            ->leftJoin('products as p', 'p.id', '=', 'receipt.product_id')
            ->where('p.title','like','%'.$title.'%')->where('receipt.user_id',$user_id)
            ->paginate($per_page);

        $count = $this->fetch_count();
        $data = array();
        if($status == 1){

            foreach($carts as $k=>$v) {

                if ($v->product) {
                    if ($v->product->assets) {
                        $cover_url = $v->product->assets->file->avatar;
                    }
                }

                $cart = ProductsModel::where(['id'=>$v->product_id])->first();
                $mode = ProductsSkuModel::where(['id'=>$v->sku_id])->first();
                $type = SkuRegionModel::where(['sku_id'=>$v->sku_id,'user_id'=>$user_id])->select('max','min','sell_price')->get();
                $collection  = CollectionModel::where(['user_id'=>$user_id,'product_id'=>$v->product_id])->first();

                if (!$cart) {
                    return $this->response->array(ApiHelper::error('该商品不存在！', 500));
                }

                if($collection){
                    $focus = 1;
                } else {
                    $focus = 0;
                }

                if($v->status == 3){
                    $v->status = false;
                } elseif($v->status == 4){
                    $v->status = true;
                }



                $data[$k] = array(
                    'id' => $v->id,
                    'product_name'=>$cart->title,//商品名称
                    'inventory' =>$mode->quantity,//商品库存数量
                    'market_price'=>$cart->market_price,//商品销售价
                    'product_id' => $v->product_id,//商品id
                    'price' => 0,//购买价格
                    'number' => $v->number,//购买数量
                    'cover_url' => $cover_url,//图片url
                    'mode' => $mode->mode,
                    'status' => $v->status,
                    'sku_region ' => $type,
                    'focus ' => $focus,//是否关注
                );
            }
            $data['count'] = $count;
        } else {

            foreach($carts as $k=>$v) {

                if ($v->product) {
                    if ($v->product->assets) {
                        $cover_url = $v->product->assets->file->avatar;
                    }
                }

                $cart = ProductsModel::where(['id'=>$v->product_id])->first();
                $mode = ProductsSkuModel::where(['id'=>$v->sku_id])->first();
                $type = SkuRegionModel::where(['sku_id'=>$v->sku_id,'user_id'=>$user_id])->select('max','min','sell_price')->get();
                $collection  = CollectionModel::where(['user_id'=>$user_id,'product_id'=>$v->product_id])->first();

                if (!$cart) {
                    return $this->response->array(ApiHelper::error('该商品不存在！', 500));
                }

                if($collection){
                    $focus = 1;
                } else {
                    $focus = 0;
                }

                $v->status = false;

                $data[$k] = array(
                    'id' => $v->id,
                    'product_name'=>$cart->title,//商品名称
                    'inventory' =>$mode->quantity,//商品库存数量
                    'market_price'=>$cart->market_price,//商品销售价
                    'product_id' => $v->product_id,//商品id
                    'price' => $v->price,//购买价格
                    'number' => $v->number,//购买数量
                    'cover_url' => $cover_url,//图片url
                    'mode' => $mode->mode,
                    'status' => $v->status,
                    'sku_region' => $type,
                    'focus' => $focus,
                );
            }

            $data['count'] = $count;
        }

        return $this->response->array(ApiHelper::success('Success.', 200, $data));
    }



    /**
     * @api {get} /DealerApi/settlement 点击结算
     * @apiVersion 1.0.0
     * @apiName Cart settlement
     * @apiGroup Cart
     * @apiParam {string} id 1:一个或多个进货单id(数组形式传参)
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "product_id": 2,                      // 商品id
     *      "sku_id": 2,                      // sku id
     *      "product_name" :"大米",            //       商品名称
     *      "cover_url"   ：1.img ,          //    图片url
     *      "price": "200.00",            // 商品价格
     *      "mode":颜色：白色 ,               //    类型
     *      "number": 1,                       // 购买数量
     *      }
     *   ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           "data" : $data,
     *       }
     *   }
     * }
     */
    public function settlement(Request $request)
    {
        $id = $request->input('id') ? $request->input('id') : '';

        $data = array();
        foreach($id as $k=>$v){
            $carts = ReceiptModel::find($v);

            if ($carts->product->assets) {
                $cover_url = $carts->product->assets->file->avatar;
            }

            $data[$k]=array(
                'product_id' => $carts->product_id,
                'sku_id'       => $carts->sku_id,
                'number'        => $carts->number,
                'price'         => $carts->price,
                'product_name'  => $carts->product->title,
                'mode'          => $carts->sku->mode,
                'cover_url'     =>$cover_url,

            );

        }

        return $this->response->array(ApiHelper::success('Success.', 200, $data));
    }





    /**
     * @api {post} /DealerApi/cart/add 添加产品到进货单
     * @apiVersion 1.0.0
     * @apiName Cart add
     * @apiGroup Cart
     *
     * @apiParam {integer} number 购买数量 默认值：1
     * @apiParam {integer} product_id 商品id 默认值：1
     * @apiParam {integer} sku_id sku的id 默认值：1
     *  @apiSuccessExample 成功响应:
     * {

     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "id"    : cart_id,
     *          "status":3,
     *       }
     *   }
     *
     */
    public function add(Request $request)
    {
        $user_id = $this->auth_user_id;

        $all = $request->all();

        foreach($all['all'] as $vue){
            $sku_price = SkuRegionModel::where(['sku_id'=>$vue['sku_id']])->get();//商品区间数量价格
            $price = '';

            //根据商品数量判断区间价格
            foreach ($sku_price as $v){
                if($vue['number'] >= $v['min'] && $vue['number'] <= $v['max']){
                    $price = $v['sell_price'] * $vue['number'];
                }
            }

            // 如果产品存在，则更新数量和价格
            $cart = ReceiptModel::where(['user_id' => $user_id,'sku_id'=>$vue['sku_id'],'product_id'=>$vue['product_id']])->first();
            if ($cart) {
                $number = $cart['number'] + $vue['number'] ;
                $price_gauge = $cart['price'] + $price;
                $receipt =  ReceiptModel::findOrFail($cart['id']);
                $receipt['number'] = $number;
                $receipt['price'] = $price_gauge;
                if (!$receipt->save()){
                    return $this->response->array(ApiHelper::error('更新失败！', 501));
                }


            } else {
                $sku = ProductsModel::where(['id'=>$vue['product_id']])->first();
                if (empty($sku)) {
                    return $this->response->array(ApiHelper::error('产品不存在！', 501));
                }

                $data = array(
                    'user_id' => $user_id,//用户id
                    'product_id' => $sku['id'],//商品id
                    'sku_id'    =>$vue['sku_id'],//sku id
                    'price' => $price,//商品价格
                    'number' => $vue['number'],//购买数量
                    'status' => 3, //区分立即购买和加入进货单  3为加入进货单 4为立即购买
                );

                $cart = ReceiptModel::create($data);
                if(!$cart) {
                    return $this->response->array(ApiHelper::error('创建失败！', 500));
                }
            }
        }
        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $cart->id)));


    }


    /**
     * @api {post} /DealerApi/cart/buy 立即购买
     * @apiVersion 1.0.0
     * @apiName Cart buy
     * @apiGroup Cart
     *
     *
     * @apiParam {integer} number 购买数量 默认值：1
     * @apiParam {integer} product_id 商品id 默认值：1
     * @apiParam {integer} sku_id sku的id 默认值：2
     *
     *  @apiSuccessExample 成功响应:
     * {

     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "id"    : cart_id,
     *          "status":4,
     *       }
     *   }
     *
     */
    public function buy(Request $request)
    {
        $user_id = $this->auth_user_id;

        $all = $request->all();

        foreach($all['all'] as $vue){
            $sku_price = SkuRegionModel::where(['sku_id'=>$vue['sku_id']])->get();//商品区间数量价格
            $price = '';

            //根据商品数量判断区间价格
            foreach ($sku_price as $v){
                if($vue['number'] >= $v['min'] && $vue['number'] <= $v['max']){
                    $price = $v['sell_price'] * $vue['number'];
                }
            }

            // 如果产品存在，则更新数量和价格
            $cart = ReceiptModel::where(['user_id' => $user_id,'sku_id'=>$vue['sku_id'],'product_id'=>$vue['product_id']])->first();
            if ($cart) {
                $number = $cart['number'] + $vue['number'] ;
                $price_gauge = $cart['price'] + $price;
                $receipt =  ReceiptModel::findOrFail($cart['id']);
                $receipt['number'] = $number;
                $receipt['price'] = $price_gauge;
                if (!$receipt->save()){
                    return $this->response->array(ApiHelper::error('更新失败！', 501));
                }


            } else {
                $sku = ProductsModel::where(['id'=>$vue['product_id']])->first();
                if (empty($sku)) {
                    return $this->response->array(ApiHelper::error('产品不存在！', 501));
                }

                $data = array(
                    'user_id' => $user_id,//用户id
                    'product_id' => $sku['id'],//商品id
                    'sku_id'    =>$vue['sku_id'],//sku id
                    'price' => $price,//商品价格
                    'number' => $vue['number'],//购买数量
                    'status' => 4, //区分立即购买和加入进货单  3为加入进货单 4为立即购买
                );

                $cart = ReceiptModel::create($data);
                if(!$cart) {
                    return $this->response->array(ApiHelper::error('创建失败！', 500));
                }
            }
        }
        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $cart->id)));

    }


    /**
     * @api {get} /DealerApi/cart/emptyShopping 清空个人购物车
     * @apiVersion 1.0.0
     * @apiName Cart emptyShopping
     * @apiGroup Cart
     *

     *
     *  @apiSuccessExample 成功响应:
     * {

     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *       }
     *   }
     *
     */
    public function emptyShopping(Request $request)
    {
        $user_id = $this->auth_user_id;
        $cart = ReceiptModel::where('user_id',$user_id)->delete;
        if($cart){
            return $this->response->array(ApiHelper::success('Success.', 200));
        } else {
            return $this->response->array(ApiHelper::error('删除失败！', 412));
        }
    }

    /**
     * @api {get} /DealerApi/cart/reduce 购物车增减数量
     * @apiVersion 1.0.0
     * @apiName Cart reduce
     * @apiGroup Cart
     *
     * @apiParam {integer} future :数组
     *                                  {
     *                                      id:1,
     *                                       number :20 ,
     *                                  }
     */
    public function reduce(Request $request)
    {
        $all = $request->input('future');
        if(empty($id)){
            return $this->response->array(ApiHelper::error('error', 500));
        }
        foreach($all as $v){
            $data =  ReceiptModel::findOrFail($v['id']);
            $sku_price = SkuRegionModel::where(['sku_id'=>$data['sku_id']])->get();//商品价格区间
            $cart = ProductsModel::where(['id'=>$v['product_id']])->first();
            $price = '';

            foreach ($sku_price as $vue){
                if($v['number'] >= $vue['min'] && $v['number'] <= $vue['max']){
                    $price = $vue['sell_price'] * $v['number'];

                } else {
                    $price = $cart['sale_price'] * $v['number'];
                }
            }

            $data['price'] = $price;


            if (!$data->save()){
                return $this->response->array(ApiHelper::error('error', 500));

            }
        }
        return $this->response->array(ApiHelper::success('Success.', 200));


    }





    /**
     * @api {post} /DealerApi/cart/deleted 删除购物车
     * @apiVersion 1.0.0
     * @apiName Cart deleted
     * @apiGroup Cart
     *
     * @apiParam {integer} id Cart id (1,4,6 支持多个ID)
     * @apiParam {string} token token
     */
    public function deleted(Request $request)
    {
        $user_id = $this->auth_user_id;
        $ids = $request->input('id') ? $request->input('id') : '';
        if (empty($ids)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 412));
        }

        $id_arr = explode(',', $ids);
        for ($i=0;$i<count($id_arr);$i++) {
            $id = (int)$id_arr[$i];
            $cart = ReceiptModel::find($id);
            if (!$cart) continue;
            if ($cart->user_id != $user_id) continue;
            $cart->delete();
        }
        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $ids)));
    }

    /**
     * @api {get} /DealerApi/cart/fetch_count 获取购物车数量
     * @apiVersion 1.0.0
     * @apiName Cart fetch_count
     * @apiGroup Cart
     *
     *  @apiSuccessExample 成功响应:
     * {

     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "count"    : 1,
     *       }
     *   }
     *
     */
    public function fetch_count()
    {
        $user_id = $this->auth_user_id;
        $count = ReceiptModel::where(['user_id' => $user_id])->count();
        return $this->response->array(ApiHelper::success('Success.', 200, array('count' => $count)));
    }


}
