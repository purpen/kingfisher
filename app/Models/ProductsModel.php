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
    protected $fillable = ['title','tit','category_id','brand_id','brand_id','supplier_id','market_price','sale_price','inventory','cover_id','unit','published','weight','cost_price','summary'];

    /**
     * 一对多关联products_sku表
     */
    public function productsSku()
    {
        return $this->hasMany('App\Models\ProductsSkuModel','product_id');
    }
    
    /**
     * 获取所属的供应商
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\SupplierModel', 'supplier_id');
    }
    
    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','cover_id');
    }

    /**
     * 一对多关联StorageSkuCount表
     */
    public function StorageSkuCount()
    {
        return $this->hasMany('App\Models\StorageSkuCountModel','product_id');
    }

    /**
     * 一对多关联订单明细表
     */
    public function OrderSku()
    {
        return $this->hasMany('App\Models\OrderSkuRelationModel','product_id');
    }

    /**
     * 一对多关联material_libraries 表
     */
    public function MaterialLibraries()
    {
        return $this->hasMany('App\Models\MaterialLibrariesModel','product_number');

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

    /**
     * 待上架商品数量
     * 
     * @return mixed
     */
    public static function verifyProductCount()
    {
        return ProductsModel::where('status',1)->count();
    }

    /**
     * 获取商品封面图
     */
    public function getFirstImgAttribute()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 1])
            ->orderBy('id','desc')
            ->first();
        if(empty($asset)){
            return url('images/default/erp_product.png');
        }
        return $asset->file->small;
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
