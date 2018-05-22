<?php
//代发渠道付款单表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorPaymentModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'distributor_payment';


    /**
     * 相对关联供应商
     */
//    public function supplier()
//    {
//        return $this->belongsTo('App\Models\SupplierModel','user_id');
//    }
}
