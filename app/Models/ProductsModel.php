<?php
/**
 * 商品表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsModel extends BaseModel
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
    protected $fillable = ['title','tit','category_id','brand_id','brand_id','supplier_id','market_price','sale_price','inventory','cover_id','unit','published','weight'];

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
        return $this->belongsTo('App\Models\AssetsModel.php','cover_id');
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

    /**
     * 更改商品状态
     * @param int $status 1|2|3
     */
    public function changeProduct($status)
    {
        if(!in_array($status, [1,2,3])){
            return false;
        }
        $this->status = $status;

        if(!$this->save()){
            return false;
        }

        return true;
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            RecordsModel::addRecord($obj, 1, 13);
        });

        self::deleted(function ($obj)
        {
            RecordsModel::addRecord($obj, 3, 13);
        });

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            RecordsModel::addRecord($obj, 2, 13,$remark);
        });
    }
}
