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
     * @api {get} /MicroApi/cart 我的购物车列表
     * @apiVersion 1.0.0
     * @apiName Cart lists
     * @apiGroup Cart
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                            // 购物车ID
     *      "product_id": 4456,           // 商品ID
     *      "sku_id": 123,           // sku ID
     *      "product_number": "116110418454",           // 商品编号
     *      "sku_number": "116110418454",           // sku编号
     *      "type": 1,                          // 类型：1.默认；2.--；
     *      "price": "200.00",                      // sku价格
     *      "n": 1,                         // 购买数量
     *      "title": "金丝楠木",                  // 商品名称
     *      "short_title": "木头",              // 商品简称
     *      "sku_name": "红色",               // 规格
     *      "cover_url":  "http://img_Url",     // 商品封面图
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
        $carts = CartModel::where('user_id', $user_id)->get();
        $data = array();
        foreach($carts as $k=>$v) {
            $title = '';
            $short_title = '';
            $sku_name = '';
            $cover_url = '';

            if ($v->product) {
                $title = $v->product->tit;
                $short_title = $v->product->title;
                if ($v->product->assets) {
                    $cover_url = $v->product->assets->file->avatar;
                }
            }
            if ($v->sku) {
                $sku_name = $v->sku->mode;
                if ($v->sku->assets) {
                    $cover_url = $v->sku->assets->file->avatar;
                }
            }

            $data[$k] = array(
                'id' => $v->id,
                'sku_id' => $v->sku_id,
                'product_id' => $v->product_id,
                'sku_number' => $v->sku_number,
                'product_number' => $v->product_number,
                'price' => $v->price,
                'n' => $v->n,
                'title' => $title,
                'short_title' => $short_title,
                'sku_name' => $sku_name,
                'cover_url' => $cover_url,
                'type' => $v->type,
                'channel_id' => $v->channel_id,
                'code' => $v->code,
                'status' => $v->status,
            );
        }
        return $this->response->array(ApiHelper::success('Success.', 200, $data));
    }

    /**
     * @api {post} /MicroApi/cart/add 添加产品到购物车
     * @apiVersion 1.0.0
     * @apiName Cart add
     * @apiGroup Cart
     *
     * @apiParam {integer} sku_id SKU ID 
     * @apiParam {integer} n 购买数量 默认值：1
     * @apiParam {integer} channel_id  渠道方ID
     * @apiParam {string}   code 推广码（备用）
     * @apiParam {string} token token
     */
    public function add(Request $request)
    {
        $user_id = $this->auth_user_id;
        $sku_id = $request->input('sku_id') ? $request->input('sku_id') : '';
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
          $ok = $cart->increment('n', $n);
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
              'sku_id' => $sku->id,
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
            $cart = CartModel::find($id);
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
     * @apiParam {integer} type 默认值 1
     * @apiParam {string} token token
     */
    public function fetch_count(Request $request)
    {
        $user_id = $this->auth_user_id;
        $type = $request->input('type') ? (int)$request->input('type') : 1;
        $count = CartModel::where(['user_id' => $user_id, 'type' => $type, 'status' => 1])->count();
        return $this->response->array(ApiHelper::success('Success.', 200, array('count' => $count)));
    }


}
