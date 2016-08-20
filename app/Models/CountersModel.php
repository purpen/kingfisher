<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CountersModel extends Model
{
    protected $dates = ['deleted_at'];
    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'counters';

    /**
     * 根据表名获取单号
     * @param $name
     * @return string
     */
    static public function get_number($name)
    {
        $number = false;
        $let_array = ['CG','CT','RKCG','CKCT','DB','RKDB','CKDB','DD','FK','SK'];    //设置允许的前缀
        if(!in_array($name,$let_array )){
            return $number;
        }
        $mark = date('Ymd');
        DB::beginTransaction();
        try{
            /*
            $counter = self::firstOrCreate(['name' =>$name, 'mark' => $mark]);
            $counter->increment('val',1);
            $count = $counter->val;
            */
            if($counter = self::where(['name' =>$name, 'mark' => $mark] )->first()){
                $count = $counter->val;
                $counter->increment('val',1);
            } else{
                $counter = new CountersModel();
                $counter->name = $name;
                $counter->mark = $mark;
                $counter->val = 1;
                $counter->save();
                $count = $counter->val;
                $counter->increment('val',1);
            }
            DB::commit();
            $pre = $name;
            if($count){
                $number = $pre . $mark . sprintf("%05d",$count);
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::info($e);
        }
        return $number;
    }
}
