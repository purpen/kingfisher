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
            $asset_id = ProductsModel::find($sku->product_id)->target_id;
            $asset = new AssetsModel();
            $purchase_sku->path = $asset->path($asset_id);
        }
        return $purchase_sku_relation;
    }
}
