<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class StorageRackModel extends Model
{
    use SoftDeletes;
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'storage_rack';

    /**
     *软删除
     */
    protected $dates = ['deleted_at'];

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','content','type','user_id','status','storage_id'];

    /**
     * 仓区列表
     *
     * @param  $storage_id integer
     * @return $list array
     */
    static public function storageRackList($storage_id)
    {
        $list = DB::table('storage_rack')->where(['storage_id' => $storage_id,'deleted_at' => null])->select('id', 'name','storage_id')->get();
        return $list;
    }
}