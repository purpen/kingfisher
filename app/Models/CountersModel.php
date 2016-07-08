<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CountersModel extends Model
{
    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'counters';

    const PURCHASE = 'CG';  //采购单号前缀

    /**
     * 根据表名获取单号
     * @param $name
     * @return string
     */
    public function get_number($name)
    {
        $count = null;
        $mark = date('Ymd');
        DB::beginTransaction();
        try{
            if($counter = self::where(['name' =>$name, 'mark' => $mark] )->first()){
                $count = $counter->val;
                $counter->increment('val',1);
            } else{
                $counter = new self;
                $counter->name = $name;
                $counter->mark = $mark;
                $counter->save();
                $count = $counter->val;
                $counter->increment('val',1);
            }
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack;
        }
        $pre = null;
        switch ($name){
            case 'purchases':
                $pre = $this->PURCHASE;
                break;

        }
        return $number = $pre . $mark . sprintf("%05d",$count);
    }
}
