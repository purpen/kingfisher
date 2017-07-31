<?php

namespace App\Models;

class CooperationRelation extends BaseModel
{
    protected $table = 'cooperation_relation';

    protected $fillable = ['user_id', 'product_id'];

    /**
     *  添加合作信息
     *
     * @param $user_id
     * @param $product_id
     * @return bool
     */
    public static function addCooperation($user_id, $product_id)
    {
        $cooperation = CooperationRelation::firstOrCreate(['user_id' => $user_id, 'product_id' => $product_id]);

        return $cooperation ? true : false;
    }

    /**
     * 取消合作
     *
     * @param $user_id
     * @param $product_id
     * @return bool
     */
    public static function deleteCooperation($user_id, $product_id)
    {
        $cooperation = CooperationRelation::where(['user_id' => $user_id, 'product_id' => $product_id]);
        $cooperation->delete();

        return true;
    }

    /**
     *  判断商品是否已合作
     *
     * @param $user_id
     * @param $product_id
     * @return bool
     */
    public static function isCooperation($user_id, $product_id)
    {
        $cooperation = CooperationRelation::where(['user_id' => $user_id, 'product_id' => $product_id])->count();

        if ($cooperation){
            return true;
        } else{
            return false;
        }
    }
}
