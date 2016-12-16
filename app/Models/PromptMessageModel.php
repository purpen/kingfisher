<?php

namespace App\Models;

/**
 * 系统警告信息表
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class PromptMessageModel extends Model
{
    use SoftDeletes;
    /**
     * 关联对应表单
     * @var string
     */
    protected $table = 'prompt_message';

    /**
     * 需要被转换成日期的属性。
     */
    protected $dates = ['deleted_at'];

    /**
     *添加异常信息
     * @param integer $type  警告类型
     * @param string $message 内容
     * @param integer $userId 操作用户（0表示系统）
     */
    public function addMessage($type,$message,$userId = 0)
    {
        $prompt = new self();
        if(self::where('message',$message)->where('status','==',0)->first()){
            return true;
        }
        $prompt->user_id = $userId;
        $prompt->type = $type;
        $prompt->message = $message;
        $prompt->status = 0;
        if(!$prompt->save()){
            Log::error('添加系统警告信息出错');
            return false;
        }else{
            return true;
        }
    }
    
}
