<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AssetsModel extends Model
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
    protected $fillable = ['user_id','name','random','size','width','height','mime','domain','path','target_id'];

    /**
     * @param $id
     * @return string
     */
    public function path($id){
        $path = '';
        if ($asset = self::where('id',$id)->first()){
            $path = config('qiniu.url') . $asset->path . config('qiniu.small');
        }
        return $path;
    }
    
    
}
