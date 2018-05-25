<?php
//代发渠道付款单表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributorPaymentModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'distributor_payment';

//    相对关联到分销商
    public function Distribution(){

        return $this->belongsTo('App\Models\Distribution','distributor_user_id');
    }

}
