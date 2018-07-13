<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivingAddressModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到收货地址表
     * @var string
     */
    protected $table = 'receiving_address';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [ 'name', 'phone', 'zip'];

}
