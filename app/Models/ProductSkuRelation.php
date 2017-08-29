<?php

namespace App\Models;
use Illuminate\Support\Facades\Log;

/**
 * 分发saas 用户-sku 关联表
 *
 * Class ProductSkuRelation
 * @package App\Models
 */
class ProductSkuRelation extends BaseModel
{
    protected $table = 'product_sku_relation';

    protected $fillable = ['product_user_relation_id', 'sku_id'];

    /**
     * 一对多 相对关联 ProductUserRelation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ProductUserRelation()
    {
        return $this->belongsTo('App\Models\ProductUserRelation', 'product_user_relation_id');
    }

    /**
     * 一对多相对关联 ProductsSkuModel
     *
     */
    public function ProductsSkuModel()
    {
        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
    }


    /**
     * 分发saas sku信息详情
     *
     * @param $user_id
     * @param $sku_id
     * @return array|null
     */
    public function skuInfo($user_id, $sku_id)
    {
        $sku = self::where(['user_id' => $user_id, 'sku_id' => $sku_id])->first();
        if ($sku) {
            $erp_sku = $sku->ProductsSkuModel;
            return [
                'sku_id' => $erp_sku->id,
                'number' => $erp_sku->number,
                'mode' => $erp_sku->mode,
                'price' =>$sku->price ? sprintf("%0.2f", $sku->price) : $erp_sku->cost_price,
                'image' => $erp_sku->saas_img,
                'inventory' => $sku->quantity,
            ];
        } else if ($erp_sku = ProductsSkuModel::find($sku_id)) {
            return [
                'sku_id' => $erp_sku->id,
                'number' => $erp_sku->number,
                'mode' => $erp_sku->mode,
                'price' => $erp_sku->cost_price,
                'image' => $sku->saas_img,
                'inventory' => $sku->quantity,
            ];
        } else {
            return null;
        }
    }


    /**
     * sku 库存变化对应修改saasproduct的库存数量
     */
    public function skuQuantityChange($id)
    {
        if(!$sku = self::find($id)){
            Log::error('saas 后台修改商品库存错误');
            return false;
        }
        $product = $sku->ProductUserRelation;
        $skus = $product->ProductSkuRelation;
        $count = 0;
        foreach ($skus as $sku){
            $count = $count + $sku->quantity;
        }

        $product->stock = $count;
        if ($product->save()){
            return true;
        }else{
            return false;
        }
    }


    /**
     * saas sku库存减少
     *
     * @param $sku_id
     * @param integer $user_id  用户ID
     * @param integer $quantity  减少的数量
     * @return array
     */
    public function reduceSkuQuantity($sku_id, $user_id, $quantity)
    {
        $sku = self::where(['user_id' => $user_id, 'sku_id' => $sku_id])->first();
        if($sku){
            $sku_quantity = $sku->quantity;
            if ($sku_quantity < $quantity){
                return [false, '库存不足'];
            }

            $sku->quantity = $sku_quantity - $quantity;

            if(!$sku->save()){
                return [false, 'db save error'];
            }

            if (!$this->skuQuantityChange($sku->id)){
                return [false, '修改saasproduct的库存数量出错'];
            }

        }else if ($sku = ProductsSkuModel::find($sku_id)){
            $sku_quantity = $sku->quantity;
            if ($sku_quantity < $quantity){
                return [false, '库存不足'];
            }
        }else{
            return [false, '未找到该sku'];
        }

        return [true, 'ok'];
    }

}