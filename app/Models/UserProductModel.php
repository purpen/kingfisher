<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProductModel extends Model
{
    /**
     * 对应的数据表
     * @var string
     */
    protected $table = 'user_product';

    protected $fillable = ['user_id', 'product_id'];

    /**
     * 添加user_product权限
     *
     * @param $user_id
     * @param $product_id
     * @return bool
     */
    public static function addUserProduct($user_id, $product_id)
    {
        $user_product = self::firstOrCreate(['user_id' => $user_id, 'product_id' => $product_id]);
        if ($user_product) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除用户查看商品权限
     *
     * @param $user_id
     * @param $product_id
     * @return bool
     */
    public static function deleteUserProduct($user_id, $product_id)
    {
        $user_product = self::where(['user_id' => $user_id, 'product_id' => $product_id])->first();

        if ($user_product) {
            $user_product->delete();
        }

        return true;
    }


    /**
     * 通过user_id获取可查看的设限商品ID数组 返回product的id数组
     *
     * @param $user_id
     * @return mixed
     */
    public static function seeUserToProductId($user_id)
    {
        $product_id_arr = self::where(['user_id' => (int)$user_id])
            ->get()
            ->pluck('product_id')
            ->all();

        return $product_id_arr;
    }


    /**
     * 通过商品ID 查看能查看该商品的用户ID数组
     *
     * @param $product_id
     * @return mixed
     */
    public static function seeProductToUserId($product_id)
    {
        $user_id_arr = self::where(['product_id' => (int)$product_id])
            ->get()
            ->pluck('user_id')
            ->all();

        return $user_id_arr;
    }


    /**
     * 用户不能查看的商品ID数组
     *
     * @param $user_id
     * @return array
     */
    public static function notSeeProductId($user_id)
    {
        // 设置了权限的商品ID数组
        $check_product_id_array = UserProductModel::select('product_id')
            ->groupBy('product_id')
            ->get()
            ->pluck('product_id')
            ->all();

        // 通过user_id获取可查看的设限商品ID数组 返回product的id数组
        $look_product_id_array = UserProductModel::seeUserToProductId((int)$user_id);

        return  array_diff($check_product_id_array, $look_product_id_array);
    }
}
