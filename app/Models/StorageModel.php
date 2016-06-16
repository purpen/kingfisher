<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StorageModel;
class StorageModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'storages';
    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','content','type','user_id','city_id','status'];

    /**
     * 设置status字段访问修改器
     */
    public function getStatusAttribute($key)
    {
        return $key?'正常':'禁用';
    }

    /**
     * 获取仓库列表
     * @param int $status
     * @return
     */
    static public function storageList($status)
    {
        if (isset($status)) {
            $list = self::where('status',$status)->select('id','name','status')->get();
        }
        else {
            $list = self::select('id','name','status')->get();
        }
        return $list;
    }

}
