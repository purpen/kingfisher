<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Models\CartModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class CartController extends BaseController
{
    /**
     * @api {get} /MicroApi/cart 购物车列表
     * @apiVersion 1.0.0
     * @apiName Cart lists
     * @apiGroup Cart
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                            // 购物车ID
     *      "product_id": 60,                   // 商品ID
     *      "product_number": "116110418454",           // 商品编号
     *      "sku_id": 60,                   // sku ID
     *      "sku_number": "116110418454",           // sku编号
     *      "type": 1,                          // 类型：1.默认；2.--；
     *      "price": "200.00",                      // sku价格
     *      "n": 1,                         // 购买数量
     *      "channel_id": 1,                      // 渠道ID(供应商ID)
     *      "code": "sIdkwWc",                         // 推广码(备用)
     *      "status": 1,                    // 状态：0.禁用；1.启用；
     *      }
     * ],
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

        $products = CartModel::where('user_id' => $user_id);

        return $this->response->array(ApiHelper::success('Success.', 200, $products)));
    }

    /**
     * @api {post} /MicroApi/cart/add 添加产品到购物车
     * @apiVersion 1.0.0
     * @apiName Cart add
     * @apiGroup Cart
     *
     * @apiParam {integer} sku_id SKU id
     * @apiParam {integer} n 购买数量 默认值：1
     * @apiParam {integer} channel_id  渠道方ID
     * @apiParam {string}   code 推广码（备用）
     * @apiParam {string} token token
     */
    public function add(Request $request)
    {
        $user_id = $this->auth_user_id;
        $sku_id = $request->input('sku_id') ? (int)$request->input('sku_id') : 0;
        $n = $request->input('n') ? (int)$request->input('n') : 1;
        $type = $request->input('type') ? (int)$request->input('type') : 1;
        $channel_id = $request->input('channel_id') ? (int)$request->input('channel_id') : 0;
        $code = $request->input('code') ? $request->input('code') : '';

        if (empty($sku_id)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 401));
        }

        // 如果产品存在，则更新数量
        $cart = CartModel::where(['user_id' => $user_id, 'sku_id' => $sku_id, 'type' => $type])->first();
        if ($cart) {
          $ok = $cart->increment('n');
          if (!$ok) {
              return $this->response->array(ApiHelper::error('更新失败！', 500));
          }
        } else {
          $sku = ProductsSkuModel::find($sku_id);
          if (empty($sku)) {
              return $this->response->array(ApiHelper::error('产品不存在！', 501));
          }

          $data = array(
              'user_id' => $user_id,
              'sku_id' => $sku_id,
              'sku_number' => $sku->number,
              'product_id' => $sku->product_id,
              'product_number' => $sku->product_number,
              'price' => $sku->price,
              'n' => $n,
              'channel_id' => $channel_id,
              'code' => $code,
              'type' => $type,
          );

          $cart = CartModel::create($data);
          if(!$cart) {
              return $this->response->array(ApiHelper::error('创建失败！', 500));       
          }       
        }

        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $cart->id)));
    }

    /**
     * @api {post} /MicroApi/cart/add 删除购物车
     * @apiVersion 1.0.0
     * @apiName Cart deleted
     * @apiGroup Cart
     *
     * @apiParam {integer} id Cart id
     * @apiParam {string} token token
     */
    public function deleted(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        if (empty($id)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 401));
        }

        $cart = CartModel::find($id);
        if (!$cart) {
            return $this->response->array(ApiHelper::error('购物车产品不存在！', 402));
        }

        if ($cart->user_id != $user_id) {
            return $this->response->array(ApiHelper::error('无权限操作!', 403));       
        }
        $ok = $cart->delete();
        if (!$ok) {
            return $this->response->array(ApiHelper::error('删除产品失败!', 500));       
        }
        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $id)));
    }

    /**
     * @api {get} /MicroApi/cart/fetch_count 获取购物车数量
     * @apiVersion 1.0.0
     * @apiName Cart fetch_count 
     * @apiGroup Cart
     *
     * @apiParam {integer} type 默认值 1
     * @apiParam {string} token token
     */
    public function fetch_count(Request $request)
    {
        $user_id = $this->auth_user_id;
        $type = $request->input('type') ? (int)$request->input('type') : 1;
        $count = CartModel::where(['user_id' => $user_id, 'type' => $type], 'status' => 1)->count();
        return $this->response->array(ApiHelper::success('Success.', 200, array('count' => $count)));
    }


}
