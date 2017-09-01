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
    protected $fillable = ['status' , 'file_name' , 'file_size','total_count','success_count', 'no_sku_count', 'repeat_outside_count', 'null_field_count', 'sku_storage_quantity_count', 'repeat_outside_string', 'no_sku_string', 'null_field_string', 'sku_storage_quantity_string',];

}
