<?php
/**
 * 发票表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceModel extends BaseModel
{


    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'invoice';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['user_id','province_id','city_id','area_id','company_name','company_phone','reviewer','audit','opening_bank','bank_account','unit_address','duty_paragraph','receiving_address','receiving_name','receiving_phone','receiving_phone','prove_id','receiving_id' , 'reason','receiving_type','application_time'];


    

    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','prove_id');
    }

    /**
     * 一对多关联发票历史表
     */
    public function history()
    {
        return $this->hasMany('App\Models\HistoryInvoiceModel', 'invoice_id');
    }


    /**
     * 获取发票封面图
     */
    public function getFirstImgInvoice()
    {
        $result = $this->imageFile();
        if(is_object($result)){
            return $result->p500;
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

//    /**
//     * 相对关联到ChinaCityModel表
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function province(){
//        return $this->belongsTo('App\Models\ChinaCityModel', 'province_id', 'oid');
//    }
//
//    /**
//     * 相对关联到ChinaCityModel表
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function city(){
//        return $this->belongsTo('App\Models\ChinaCityModel', 'city_id', 'oid');
//    }
//
//    /**
//     * 相对关联到ChinaCityModel表
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function county(){
//        return $this->belongsTo('App\Models\ChinaCityModel', 'area_id', 'oid');
//    }


}
