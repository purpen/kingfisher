<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductsModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'products';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['title','category_id','brand_id','brand_id','supplier_id','market_price','sale_price','inventory','cover_id','unit','published','number','weight'];

    /**
     * 一对多关联products_sku表
     */
    public function productsSku(){
        return $this->hasMany('App\Models\ProductsSkuModel','product_id');
    }

    /**
     * 一对多关联assets表单
     */
    public function assets(){
        return $this->hasMany('App\Models\AssetsModel.php','target_id');
    }

    /**
     * 一对多关联StorageSkuCount表
     */
    public function StorageSkuCount(){
        return $this->hasMany('App\Models\StorageSkuCountModel','product_id');
    }


    /**
     * 增加库存
     * @param $product
     * @param array $sku
     * @return bool
     */
    public function addInventory($product,array $sku){
        $sum = 0;
        foreach ($sku as $key=>$value){
            if($skuModel = ProductsSkuModel::find($key)){
                $skuModel->count = $skuModel->count + (int)$value;
                if(!$skuModel->save()){
                    return false;
                }
            }else{
                return false;
            }
            $sum += (int)$value;
        }
        if(!$productModel = self::find($product)){
            return false;
        }
        $productModel->count = $productModel->count + $sum;
        if(!$productModel->save()){
            return false;
        }
        return true;
    }
}
