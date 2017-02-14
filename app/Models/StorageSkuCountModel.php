<?php
/**
 * 某仓库商品库存数
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class StorageSkuCountModel extends BaseModel
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
    protected $fillable = ['storage_id','sku_id','department'];

    /**
     * 相对关联关联products表
     */
    public function Products()
    {
        return $this->belongsTo('App\Models\ProductsModel','product_id');
    }

    /**
     * 相对关联ProductsSku表
     */
    public function ProductsSku()
    {
        return $this->belongsTo('App\Models\ProductsSkuModel','sku_id');
    }

    /**
     * 相对关联Storage表
     */
    public function Storage()
    {
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    /**
     * 相对关联StorageRack表
     */
    public function StorageRack()
    {
        return $this->belongsTo('App\Models\StorageRackModel','storage_rack_id');
    }

    /**
     * 相对关联StoragePlace表
     */
    public function StoragePlace()
    {
        return $this->belongsTo('App\Models\StoragePlaceModel','storage_place_id');
    }

    /**
     * 一对多关联rackplace订单表
     */
    public function RackPlace()
    {
        return $this->hasMany('App\Models\RackPlaceModel','storage_sku_count_id');
    }

    /**
     * 部门名称
     */
    public function getDepartmentValAttribute()
    {
        $val = '';
        switch ($this->department){
            case 0:
                break;
            case 1:
                $val = 'fiu';
                break;
            case 2:
                $val = 'D3IN';
                break;
            case 3:
                $val = '海外';
                break;
            case 4:
                $val = '电商';
                break;
            default:
        }
        return $val;
    }

    /**
     * 2017.2.13 逻辑修改 增加部门类型  --llh
     *
     * sku入库 增加对应仓库库存
     * @param int $storage_id 仓库ID
     * @param int $department 部门类型
     * @param array $sku_id sku id的数组
     * @param true|false
     */
    public function enter($storage_id, $department, array $sku_arr)
    {
        foreach ($sku_arr as $sku_id => $count){
            $storage_sku_model = self::firstOrCreate(['storage_id' => $storage_id,'sku_id' =>$sku_id, 'department' => $department]);
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
    public function out($storage_id, $department, array $sku_arr)
    {
        foreach ($sku_arr as $sku_id => $count){
            $storage_sku_model = StorageSkuCountModel::where(['storage_id' => $storage_id,'sku_id' =>$sku_id, 'department' => $department])->first();
            $storage_sku_model->count = $storage_sku_model->count - $count;
            if(!$storage_sku_model->save()){
                return false;
            }
        }
        return true;
    }

    /**
     * 指定仓库/部门 sku列表
     * @param $storage_id
     * @param $department
     * @return array
     */
    public function skuList($storage_id, $department)
    {
        if(empty($storage_id)){
            return false;
        }
        $storage_sku = self::where(['storage_id' => (int)$storage_id, 'department' => $department])->orderBy('id','desc')->take(20)->get();
        $productsku = new ProductsSkuModel();
        $storage_sku = $productsku->detailedSku($storage_sku);
        return $storage_sku;
    }

    /**
     * 根据sku编号或商品名称搜索指定仓库/部门 sku
     * @param $storage_id
     * @param $department
     * @param $where
     * @return array
     */

    public function search($storage_id, $department, $where)
    {
        $product_id_array = ProductsModel::where('title','like',"%$where%")->select('id')->get()->pluck('id')->all();
        $sku_id_array = ProductsSkuModel::whereIn('product_id',$product_id_array)->select('id')->get()->pluck('id')->all();
        $skus = self::where(['storage_id' => (int)$storage_id, 'department' => $department])->whereIn('sku_id',$sku_id_array)->get();
        $product_sku = new ProductsSkuModel();
        $skus = $product_sku->detailedSku($skus);
        return $skus;
    }


    /**
     * 判断库存可售数量，是否满足该订单
     * @param int $storage_id
     * @param array $sku_id
     * @param array $count
     * @return bool
     */
    public function isCount($storage_id, $department, array $sku_id, array $count)
    {
        for ($i = 0; $i < count($sku_id); $i++){
            $storage_sku = StorageSkuCountModel::where(['storage_id' => $storage_id,'department' => $department,'sku_id' => $sku_id[$i]])->first();
            if(!$storage_sku){
                return false;
            }
            //判断该sku可卖库存量 是否满足订单
            if($count[$i] > $storage_sku->count - $storage_sku->reserve_count - $storage_sku->pay_count){

                $storage_name = StorageModel::find($storage_id)->name;
                $message = new PromptMessageModel();
                $message->addMessage(2,"仓库:$storage_name ," . 'SKU编号：' . $storage_sku->ProductsSku->number . '库存不足');
                Log::error('SKU编号：' . $storage_sku->ProductsSku->number . '库存不足');
                return false;
            }
        }
        return true;
    }

    /**
     * 创建订单时 增加对应仓库付款占货量（该方法准备废弃）
     *
     * @param array $storage_id
     * @param array $sku_id
     * @param array $count
     * @return bool
     */
    /*public function increasePayCount(array $storage_id, array $sku_id, array $count)
    {
        for ($i = 0; $i < count($storage_id); $i++){
            $storage_sku = self::where(['storage_id' => $storage_id[$i],'sku_id' => $sku_id[$i]])->first();
            if(!$storage_sku){
                return false;
            }
            $storage_sku->pay_count += $count[$i];
            if(!$storage_sku->save()){
                return false;
            }
        }
        return true;
    }*/
    
    /**
     * 删除付款待审核订单 或 订单发货时，减少仓库付款占货（该方法准备废弃）
     * @param $order_id
     * @return bool
     */
    /*public function decreasePayCount($order_id)
    {
        $order_id = (int)$order_id;
        if(!$order = OrderModel::find($order_id)){
            return false;
        }
        $storage_id = $order->storage_id;

        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();
        if(!$order_sku){
            return false;
        }
        foreach ($order_sku as $sku){
            $storage_sku_count = StorageSkuCountModel::where(['storage_id' => $storage_id,'sku_id' => $sku->sku_id])->first();
            $storage_sku_count->pay_count -= $sku->count;
            if(!$storage_sku_count->save()){
                return false;
            }
        }
        return true;
    }*/

    /**
     * 删除待付款待订单 或 订单付款时，减少仓库拍下占货数量（该方法准备废弃）
     * @param $order_id
     * @return bool
     */
    /*public function decreaseReserveCount($order_id)
    {
        $order_id = (int)$order_id;
        if(!$order = OrderModel::find($order_id)){
            return false;
        }
        $storage_id = $order->storage_id;

        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();
        if(!$order_sku){
            return false;
        }
        foreach ($order_sku as $sku){
            $storage_sku_count = StorageSkuCountModel::where(['storage_id' => $storage_id,'sku_id' => $sku->sku_id])->first();
            $storage_sku_count->reserve_count -= $sku->count;
            if(!$storage_sku_count->save()){
                return false;
            }
        }
        return true;
    }*/

    /**
     * 某仓库 某商品SKU 可销售数量
     * @return mixed
     */
    public function sellCount()
    {
        $count = $this->count - $this->reserve_count - $this->pay_count;
        return $count;
    }

    /**
     * 统计仓库的库存成本
     *
     * @param string $storage_id
     * @return int
     */
    public function everyStorageCount($storage_id = '')
    {
        if($storage_id){
            $storage_sku = self::where('storage_id',$storage_id)->get();
        }else{
            $storage_sku = self::get();
        }
        $money = 0;
        foreach ($storage_sku as $sku){
            $money += $sku->count * $sku->ProductsSku->cost_price;
        }
        return $money;
    }
}