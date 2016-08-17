<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PaymentAccountModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'payment_account';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['store_id', 'bank', 'account', 'summary'];

    /**
     * 相对关联Store表
     */
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

}
