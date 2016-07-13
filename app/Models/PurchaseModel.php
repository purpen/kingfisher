<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PurchaseModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'purchases';

    /**
     * 生成展示列表
     * @param $purchases
     * @return mixed
     */
    public function lists($purchases){
        foreach ($purchases as $purchase){
            $purchase->supplier = (SupplierModel::find($purchase->supplier_id)->name) . "<".$purchase->supplier_id.">";
            $purchase->storage = StorageModel::find($purchase->storage_id)->name;
            $purchase->user = UserModel::find($purchase->user_id)->realname;
        }
        return $purchases;
    }
}
