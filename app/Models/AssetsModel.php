<?php
/**
 * 附件列表（图片）
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetsModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'assets';

    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'random', 'size', 'width', 'height', 'mime', 'domain', 'path', 'target_id', 'type'];

    /**
     * 一对一关联products表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasOne('App\Models\ProductsModel', 'cover_id');
    }
    /**
     * 一对一关联products表商品详情
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productProductDetails()
    {
        return $this->hasOne('App\Models\ProductsModel', 'product_details');
    }

//    /**
//     * 一对一关联distributor表
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function distributor()
//    {
//        return $this->hasOne('App\Models\DistributorModel', 'license_id');
//    }

    /**
     * 一对一关联productSku表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsSku()
    {
        return $this->hasOne('App\Models\ProductsSkuModel', 'cover_id');
    }

    /**
     * 一对一关联user表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasOne('App\Models\UserModel', 'cover_id');
    }

    /**
     * 一对一关联供应商
     */
    public function supplier()
    {
        return $this->hasOne('App\Models\SupplierModel', 'cover_id');
    }

    /**
     * 一对一关联供应商商标
     */
    public function supplierTrademark()
    {
        return $this->hasOne('App\Models\SupplierModel', 'trademark_id');
    }

    /**
     * 一对一关联供应商授权书
     */
    public function supplierPowerOfAttorney()
    {
        return $this->hasOne('App\Models\SupplierModel', 'power_of_attorney_id');
    }

    /**
     * 一对一关联供应商质检报告
     */
    public function supplierQualityInspectionReport()
    {
        return $this->hasOne('App\Models\SupplierModel', 'quality_inspection_report_id');
    }

    /**
     * 一对一关联供应商电子版合同
     */
    public function supplierElectronicContractReport()
    {
        return $this->hasOne('App\Models\SupplierModel', 'electronic_contract_report_id');
    }

    //一对一关联经销商表门店正面照片
    public function distributorFront()
    {
        return $this->hasOne('App\Models\DistributorModel','front_id');
    }
    //一对一关联经销商表门店内部照片
    public function distributorInside()
    {
        return $this->hasOne('App\Models\DistributorModel','Inside_id');
    }
    //一对一关联经销商表身份证人像面照片
    public function distributorPortrait()
    {
        return $this->hasOne('App\Models\DistributorModel','portrait_id');
    }
    //一对一关联经销商表身份证国徽面照片
    public function distributorNationalEmblem()
    {
        return $this->hasOne('App\Models\DistributorModel','national_emblem_id');
    }
    //一对一关联订单表经销商银行转账凭证图片
    public function order()
    {
        return $this->hasOne('App\Models\OrderModel','voucher_id');
    }
    //一对一关联订单表经销商电子版合同照片
    public function distributorContract()
    {
        return $this->hasOne('App\Models\DistributorModel','contract_id');
    }


    //一对一关联发票表一般纳税人证明照片
    public function invoice()
    {
        return $this->hasOne('App\Models\InvoiceModel', 'prove_id');
    }

    //一对一关联历史发票表一般纳税人证明照片
    public function historyInvoice()
    {
        return $this->hasOne('App\Models\HistoryInvoiceModel', 'prove_id');
    }



    /**
     * 获取原文件及缩略图/头像
     */
    public function getFileAttribute()
    {
        return (object)[
            'id' => $this->id,
            'name' => $this->name,
            'srcfile' => config('qiniu.url') . $this->path,
            'small' => config('qiniu.url') . $this->path . config('qiniu.small'),
            // 头像文件
            'avatar' => config('qiniu.url') . $this->path . '-ava',
            'p500' => config('qiniu.url') . $this->path . '-p500',
            'p800' => config('qiniu.url') . $this->path . '-p800',
            'p1080' => config('qiniu.url') . $this->path . '-p1080',
        ];
    }


}
