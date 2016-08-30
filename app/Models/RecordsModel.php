<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class RecordsModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'records';

    /**
     * 添加用户操作记录
     * @param object $obj  被操作的对象
     * @param int $evt 用户行为
     * @param int $type  model类型
     * @param string $remark  操作备注
     * @return bool
     */
    public static function addRecord($obj,$evt,$type,$remark=''){
        $record = new self;
        $record->user_id = Auth::User()->id;
        $record->target_id = $obj->id;
        $record->evt = $evt;
        $record->type = $type;
        $record->remark = $remark;
        if(!$record->save()){
            return false;
        }
        return true;
    }
}
