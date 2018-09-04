<?php

namespace App\Http\Controllers\Api\DealerV1;

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
     * @api {get} /MicroApi/cart 我的进货单列表
     * @apiVersion 1.0.0
     * @apiName Cart lists
     * @apiGroup Cart
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                      // 购物车ID
     *      "product_id": 4456,           // 商品ID
     *      "product_number": "大米",     // 商品名称
     *      "type": 1,                    // 类型id
     *      "price": "200.00",            // 商品价格
     *      "n": 1,                       // 购买数量
     *      "status": 1,                  // 状态：0.禁用；1.启用；
     *      }
     *   ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *       }
     *   }
     * }
     */
    public function lists(Request $request)
    {
        $user_id = $this->auth_user_id;
        $carts = ReceiptModel::where('user_id', $user_id)->paginate(8);;
        $data = array();
        foreach($carts as $k=>$v) {

            if ($v->product) {
                if ($v->product->assets) {
                    $cover_url = $v->product->assets->file->avatar;
                }
            }

            $cart = ProductsModel::where(['id'=>$v->product_id])->first();
            $mode = ProductsSkuModel::where(['id'=>$v->sku_id])->first();
            $type = SkuRegionModel::where(['sku_id'=>$v->sku_id])->get();

            if (!$cart) {
                return $this->response->array(ApiHelper::error('该商品不存在！', 500));
            }

            if($v->status == 3){
                $v->status = false;
            } elseif($v->status == 4){
                $v->status = true;
            }



            $data[$k] = array(
                'id' => $v->id,
                'product_name'=>$cart->title,//商品名称
                'inventory' =>$cart->inventory,//商品库存数量
                'market_price'=>$cart->market_price,//商品销售价
                'product_id' => $v->product_id,//商品id
                'price' => $v->price,//购买价格
                'number' => $v->number,//购买数量
                'cover_url' => $cover_url,//图片url
                'mode' => $mode->mode,
                'status' => $v->status,
            );
        }
        $data['type'] = $type;
        return $this->response->array(ApiHelper::success('Success.', 200, $data));
    }





    /**
     * @api {post} /MicroApi/cart/add 添加产品到进货单
     * @apiVersion 1.0.0
     * @apiName Cart add
     * @apiGroup Cart
     *
     * @apiParam {integer} n 购买数量 默认值：1
     */
    public function add(Request $request)
    {
        $user_id = $this->auth_user_id;

        $all = $request->all();

        foreach($all as $vue){
            $sku_price = SkuRegionModel::where(['sku_id'=>$vue->sku_id])->get();//商品区间数量价格
            $sku_products = ProductsSkuModel::where(['sku_id'=>$vue->sku_id])->first();//sku数据
            $price = '';
            $mode = $sku_products->mode;//商品颜色/型号

            //根据商品数量判断区间价格
            foreach ($sku_price as $v){
                if($vue->number > $v->min && $vue->number < $v->max){
                    $price = $v->sell_price * $vue->number;
                }
            }

            // 如果产品存在，则更新数量和价格
            $cart = ReceiptModel::where(['user_id' => $user_id,'sku_id'=>$vue->sku_id,'product_id'=>$vue->product_id])->first();
            if ($cart) {
                $number = $cart->number + $vue->number ;
                $price_gauge = $cart->price + $price;
                $ok = $cart->increment('number',$number  ,['price'=>DB::raw($price_gauge)]);
                if (!$ok) {
                    return $this->response->array(ApiHelper::error('更新失败！', 500));
                }
            } else {
                $sku = ProductsModel::find($vue->product_id);
                if (empty($sku)) {
                    return $this->response->array(ApiHelper::error('产品不存在！', 501));
                }

                $data = array(
                    'user_id' => $user_id,//用户id
                    'product_id' => $sku->product_id,//商品id
                    'price' => $price,//商品价格
                    'number' => $vue->number,//购买数量
                    'type' => $mode,//购买类型
                    'status' => 3, //区分立即购买和加入进货单  3为加入进货单 4为立即购买
                );

                $cart = ReceiptModel::create($data);
                if(!$cart) {
                    return $this->response->array(ApiHelper::error('创建失败！', 500));
                }
            }
        }
        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $cart->id)));

//
//        $n = $request->input('n') ? (int)$request->input('n') : 1;//购买数量
//        $product_id = $request->input('product_id') ? (int)$request->input('product_id') : 0;//商品id
//        $sku_id = $request->input('sku_id') ? (int)$request->input('sku_id') : 1;//skuid

//        $sku_price = SkuRegionModel::where(['sku_id'=>$sku_id])->get();//商品区间数量价格
//        $sku_products = ProductsSkuModel::where(['sku_id'=>$sku_id])->first();//sku数据
//        $price = '';
//        $mode = $sku_products->mode;//商品颜色/型号
//
//        //根据商品数量判断区间价格
//        foreach ($sku_price as $v){
//            if($n > $v->min && $n < $v->max){
//                $price = $v->sell_price * $n;
//            }
//        }
//
//        // 如果产品存在，则更新数量和价格
//        $cart = ReceiptModel::where(['user_id' => $user_id,'sku_id'=>$sku_id,'product_id'=>$product_id,'status'=>3])->first();
//        if ($cart) {
//            $ok = $cart->increment('n', $n ,['price'=>DB::raw($price)]);
//            if (!$ok) {
//                return $this->response->array(ApiHelper::error('更新失败！', 500));
//            }
//        } else {
//            $sku = ProductsModel::find($product_id);
//            if (empty($sku)) {
//                return $this->response->array(ApiHelper::error('产品不存在！', 501));
//            }
//
//            $data = array(
//                'user_id' => $user_id,//用户id
//                'product_id' => $sku->product_id,//商品id
//                'price' => $price,//商品价格
//                'n' => $n,//购买数量
//                'type' => $mode,//购买类型
//                'status' => 3, //区分立即购买和加入进货单  3为加入进货单 4为立即购买
//            );
//
//            $cart = ReceiptModel::create($data);
//            if(!$cart) {
//                return $this->response->array(ApiHelper::error('创建失败！', 500));
//            }
//        }

    }


    /**
     * @api {post} /MicroApi/cart/add 立即购买
     * @apiVersion 1.0.0
     * @apiName Cart add
     * @apiGroup Cart
     *
     * @apiParam {integer} n 购买数量 默认值：1
     */
    public function buy(Request $request)
    {
        $user_id = $this->auth_user_id;

        $all = $request->all();

        foreach($all as $vue){
            $sku_price = SkuRegionModel::where(['sku_id'=>$vue->sku_id])->get();//商品区间数量价格
            $sku_products = ProductsSkuModel::where(['sku_id'=>$vue->sku_id])->first();//sku数据
            $price = '';
            $mode = $sku_products->mode;//商品颜色/型号

            //根据商品数量判断区间价格
            foreach ($sku_price as $v){
                if($vue->number > $v->min && $vue->number < $v->max){
                    $price = $v->sell_price * $vue->number;
                }
            }

            // 如果产品存在，则更新数量和价格
            $cart = ReceiptModel::where(['user_id' => $user_id,'sku_id'=>$vue->sku_id,'product_id'=>$vue->product_id])->first();
            if ($cart) {
                $number = $cart->number + $vue->number ;
                $price_gauge = $cart->price + $price;
                $ok = $cart->increment('number',$number  ,['price'=>DB::raw($price_gauge)]);

                if (!$ok) {
                    return $this->response->array(ApiHelper::error('更新失败！', 500));
                }
            } else {
                $sku = ProductsModel::find($vue->product_id);
                if (empty($sku)) {
                    return $this->response->array(ApiHelper::error('产品不存在！', 501));
                }

                $data = array(
                    'user_id' => $user_id,//用户id
                    'product_id' => $sku->product_id,//商品id
                    'price' => $price,//商品价格
                    'number' => $vue->number,//购买数量
                    'type' => $mode,//购买类型
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
     *
     * 清空个人购物车
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
     * 购物车添加、减少产品数量和价格
     */
    public function reduce(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return $this->response->array(ApiHelper::error('error', 500));
        }

        $data =  ReceiptModel::findOrFail($id);
        $data->number = $request->input('number') ? $request->input('number') : '';//数量
        $sku_price = SkuRegionModel::where(['sku_id'=>$data->sku])->get();//商品价格区间

        $price = '';
        foreach ($sku_price as $v){
            if($data->number > $v->min && $data->number < $v->max){
                $price = $v->sell_price * $data->number;

            }
        }
        if($price){
            $data->price = $price;
        } else {
            $data->price = 0;
        }

        if ($data->save()){
            return $this->response->array(ApiHelper::success('Success.', 200));
        }else{
            return $this->response->array(ApiHelper::error('error', 500));
        }

    }


    /**
     * @api {post} /MicroApi/cart/deleted 删除购物车
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
     * @api {get} /MicroApi/cart/fetch_count 获取购物车数量
     * @apiVersion 1.0.0
     * @apiName Cart fetch_count
     * @apiGroup Cart
     *
     * @apiParam {integer} sku_name
     * @apiParam {string} token token
     */
    public function fetch_count(Request $request)
    {
        $user_id = $this->auth_user_id;
        $count = ReceiptModel::where(['user_id' => $user_id])->count();
        return $this->response->array(ApiHelper::success('Success.', 200, array('count' => $count)));
    }


}
