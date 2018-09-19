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
    protected $fillable = ['user_id','order_id','invoice_id','reviewer','audit','company_name','company_phone','opening_bank','bank_account','unit_address','duty_paragraph','receiving_address','receiving_name','receiving_phone','invoice_value','prove_id','receiving_id' , 'reason','receiving_type','difference','application_time'];


    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','prove_id');
    }

    /**
     * 一对多关联order表单
     */
    public function order()
    {
        return $this->belongsTo('App\Models\OrderModel','order_id');
    }

    /**
     * 相对关联到发票历史表表
     */
    public function historyInvoice()
    {
        return $this->belongsTo('App\Models\InvoiceModel', 'invoice_id');
    }


    /**
     * 获取发票封面图
     */
    public function getFirstImgInvoice()
    {
        $result = $this->imageFile();
        if(is_object($result)){
            return $result->srcfile;
        }
        return $result;
    }

    /**
     * 获取发票图片信息对象
     */
    public function imageFile()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 24])
            ->orderBy('id','desc')
            ->first();
        if(empty($asset)){
            return url('images/default/erp_product.png');
        }
        return $asset->file;
    }

}
