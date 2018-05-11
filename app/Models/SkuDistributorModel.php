<?php
/**
 * sku_distributor表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkuDistributorModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'sku_distributors';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['sku_number' , 'distributor_id' , 'distributor_number' , 'sku_name' , 'distributor_name'];

}
