<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SupplierModel;
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
    public function lists($where=null,$supplier_id=null){
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
}
