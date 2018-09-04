<?php
/**
 * 进货单表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'receipt';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['product_id','sku_id','user_id','price','status','n'];

    /**
     * 相对关联到product表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo('App\Models\ProductsModel', 'product_id');
    }

    /**
     * 相对关联到sku表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku(){
        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
    }

    /**
     * 购物车商品添加至订单中，将选中的商品在购物车中清空
     *
     * $user_id    用户id
     * 数组array   $data  cart  id
     *
     * @return bool
     */

    public function reduceNum(array $data,$user_id)
    {
        if(empty($user_id)){
            return false;
        }

        $id_arr = explode(',', $data);
        for ($i=0;$i<count($id_arr);$i++) {
            $id = (int)$id_arr[$i];
            $cart = ReceiptModel::find($id);
            if (!$cart) continue;
            if ($cart->user_id != $user_id) continue;
            $cart->delete();
        }
        return true;


    }

}
