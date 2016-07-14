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
     * 根据数组对象中的相关id,为对象添加 仓库/供货商/用户名;
     * @param $purchases
     * @return mixed
     */
    public function lists($purchases){
        foreach ($purchases as $purchase){
            $purchase->supplier = (SupplierModel::find($purchase->supplier_id)->name);
            $purchase->storage = StorageModel::find($purchase->storage_id)->name;
            $purchase->user = UserModel::find($purchase->user_id)->realname;
        }
        return $purchases;
    }
}
