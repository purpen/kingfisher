<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductsSkuModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'products_sku';

    /**
     * 相对关联到product表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo('App\Models\ProductsModel','product_id');
    }
    /**
     * 一对多关联StorageSkuCount表
     */
    public function StorageSkuCount(){
        return $this->hasMany('App\Models\StorageSkuCountModel','sku_id');
    }
    /**
     *sku列表
     * @param $where <模糊搜索查询参数>
     * @param $supplier_id <商品分类id>
     * @return mixed
     */
    public function lists($where=null,$supplier_id=null)
    {
        if ($where){
            $skus = self::where('name','like',"%$where%")->orWhere('number','like',"%$where%")->get();
        }else{
            $skus = SupplierModel::find($supplier_id)->productsSku()->get();
        }
        foreach ($skus as $sku){
            $cover_id = $sku->product->cover_id;
            $asset = new AssetsModel();
            $sku->path = $asset->path($cover_id);
        }
        return $skus;
    }

    /**
     * 为含有sku_id的数组对象添加该sku的详细信息
     * @param  $purchase_sku_relation
     * @return array
     */
    public function detailedSku($purchase_sku_relation)
    {
        foreach ($purchase_sku_relation as $purchase_sku){
            $sku = ProductsSkuModel::find($purchase_sku->sku_id);
            $purchase_sku->number = $sku->number;
            $purchase_sku->name = $sku->name;
            $purchase_sku->mode = $sku->mode;
            $purchase_sku->price = $sku->price;
            $asset_id = ProductsModel::find($sku->product_id)->cover_id;
            $asset = new AssetsModel();
            $purchase_sku->path = $asset->path($asset_id);
        }
        return $purchase_sku_relation;
    }

    /**
     * 增加所有仓库 总商品库存，sku库存
     * @param array $sku (sku_id => 增加库存 键值对)
     * @return bool
     */
    public function addInventory(array $sku){
        foreach ($sku as $key=>$value){
            if($skuModel = self::find($key)){
                $skuModel->quantity = $skuModel->quantity + (int)$value;
                if(!$skuModel->save()){
                    return false;
                }
                $productModel = $skuModel->product;
                $productModel->inventory = $productModel->inventory + (int)$value;
                if(!$productModel->save()){
                    return false;
                }
            }else{
                return false;
            }
        }
        return true;
    }

    /**
     * 减少库存
     * @param array $sku (sku_id => 减少库存 键值对)
     * @return bool
     */
    public function reduceInventory(array $sku){
        foreach ($sku as $key=>$value){
            if($skuModel = self::find($key)){
                $skuModel->quantity = $skuModel->quantity - (int)$value;
                if(!$skuModel->save()){
                    return false;
                }
                $productModel = $skuModel->product;
                $productModel->inventory = $productModel->inventory - (int)$value;
                if(!$productModel->save()){
                    return false;
                }
            }else{
                return false;
            }
        }
        return true;
    }

    /**
     *
     * 一对多关联库存表
     *
     */
    public function storageSkuCounts(){
        return $this->hasMany('App\Models\StorageSkuCountModel','sku_id');
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            RecordsModel::addRecord($obj, 1, 14);
        });

        self::deleted(function ($obj)
        {
            RecordsModel::addRecord($obj, 3, 14);
        });

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            RecordsModel::addRecord($obj, 2, 14,$remark);
        });
    }
}


