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
    protected $table = 'storage';
    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','content','type','user_id','city_id','status'];

    /**
     * 获取仓库列表
     * @param int $status
     * @return
     */
    static public function storageList($status)
    {
        if (isset($status)) {
            $list = StorageModel::where('status',$status)->select('id','name','status')->get();
        }
        else {
            $list = DB::table('storage')->where('deleted_at',null)->select('id','name','status')->get();
//            $list = StorageModel::select('id','name','status')->get();
        }
        array_map(function ($v){
            if($v->status){
                $v->status = '正常';
            }else{
                $v->status = '禁用';
            }
            return $v;
        },$list);
        return $list;
    }

}
