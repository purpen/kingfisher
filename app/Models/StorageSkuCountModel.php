<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorageSkuCountModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'storage_sku_count';
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['storage_id','sku_id'];

    /**
     * 相对关联关联products表
     */
    public function Products(){
        return $this->belongsTo('App\Models\ProductsModel','product_id');
    }

    /**
     * 相对关联ProductsSku表
     */
    public function ProductsSku(){
        return $this->belongsTo('App\Models\ProductsSkuModel','sku_id');
    }

    /**
     * 相对关联Storage表
     */
    public function Storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    /**
     * 相对关联StorageRack表
     */
    public function StorageRack(){
        return $this->belongsTo('App\Models\StorageRackModel','storage_rack_id');
    }

    /**
     * 相对关联StorageRack表
     */
    public function StoragePlace(){
        return $this->belongsTo('App\Models\StoragePlaceModel','storage_place_id');
    }
    /**
     * sku入库 增加对应仓库库存
     * @param $storage_id
     * @param $sku_id
     * @param $count
     */
    public function enter($storage_id,array $sku_arr)
    {
        foreach ($sku_arr as $sku_id => $count){
            $storage_sku_model = StorageSkuCountModel::firstOrCreate(['storage_id' => $storage_id,'sku_id' =>$sku_id]);
            $storage_sku_model->count = $storage_sku_model->count + $count;

            if(!$product_model = ProductsSkuModel::find($sku_id)->product){
                return false;
            }
            $storage_sku_model->product_id = $product_model->id;
            $storage_sku_model->product_number = $product_model->number;
            if(!$storage_sku_model->save()){
                return false;
            }
        }
        return true;
    }

    /**SKU出库 减少对应仓库库存
     * @param $storage_id
     * @param $sku_id
     * @param $count
     */
    public function out($storage_id,array $sku_arr)
    {
        foreach ($sku_arr as $sku_id => $count){
            $storage_sku_model = StorageSkuCountModel::where(['storage_id' => $storage_id,'sku_id' =>$sku_id])->first();
            $storage_sku_model->count = $storage_sku_model->count - $count;
            if(!$storage_sku_model->save()){
                return false;
            }
        }
        return true;
    }

    /**
     * 指定仓库sku列表
     * @param $storage_id
     * @return array
     */
    public function skuList($storage_id){
        if(empty($storage_id)){
            return false;
        }
        $storage_sku = self::where('storage_id',(int)$storage_id)->get();
        $productsku = new ProductsSkuModel();
        $storage_sku = $productsku->detailedSku($storage_sku);
        return $storage_sku;
    }

    /**
     * 根据sku编号或商品名称搜索指定仓库sku
     * @param $storage_id
     * @param $where
     * @return array
     */
    public function search($storage_id,$where){
        $storage_sku = self::join('products_sku','storage_sku_count.sku_id','=','products_sku.id')
            ->where('storage_id',$storage_id)
            ->Where('products_sku.name','like',"%$where%")
            ->orWhere('products_sku.number','like',"%$where%")
            ->get();
        return $storage_sku;
    }
}