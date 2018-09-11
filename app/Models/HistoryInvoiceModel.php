<?php
/**
 * 商品表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryInvoiceModel extends BaseModel
{


    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'history_invoice';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['order_id','invoice_id','reviewer','audit','apply','company_name','company_phone','opening_bank','bank_account','unit_address','duty_paragraph','receiving_address','receiving_name','receiving_phone','invoice_value','prove_id','receiving_id' , 'reason','receiving_type','difference','application_time'];


    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','prove_id');
    }

}
