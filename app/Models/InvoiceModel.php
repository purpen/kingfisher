<?php
/**
 * 发票表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'invoice';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['user_id','company_name','company_phone','reviewer','audit','apply','opening_bank','bank_account','unit_address','duty_paragraph','receiving_address','receiving_name','invoice_value','receiving_phone','prove_id','receiving_id' , 'reason','receiving_type','application_time'];


    

    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','prove_id');
    }

}
