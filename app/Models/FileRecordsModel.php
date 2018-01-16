<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileRecordsModel extends BaseModel
{
    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'file_records';

    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['status' , 'file_name' , 'file_size','total_count','success_count', 'no_sku_count', 'repeat_outside_count', 'null_field_count', 'sku_storage_quantity_count', 'repeat_outside_string', 'no_sku_string', 'null_field_string', 'sku_storage_quantity_string', 'summary' , 'product_unopened_count' , 'product_unopened_string'];


    /**
     * 导入订单记录Status访问修改器
     * 状态: 0.进行中1.已完成 2.失败的
     *
     * @return string
     */
    public function getStatusValAttribute()
    {
        switch ($this->status) {
            case 0:
                $status = '进行中';
                break;
            case 1:
                $status = '已完成';
                break;
            case 2:
                $status = '失败的';
                break;
            default:
                $status = '进行中';
        }

        return $status;
    }
}
