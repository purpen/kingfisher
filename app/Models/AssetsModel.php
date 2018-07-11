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
     * 一对一关联distributors表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function distributor()
    {
        return $this->hasOne('App\Models\DistributorsModel', 'cover_id');
    }

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
        ];
    }


}
