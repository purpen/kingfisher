<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RecordsModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'records';

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['type', 'user_id', 'evt', 'target_id','target_model_name', 'type', 'remark', 'status'];

    //相对关联用户表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    /**
     * 添加用户操作记录
     * @param object $obj  被操作的对象
     * @param int $evt 用户行为
     * @param int $type  model类型
     * @param string|array $remark  操作备注
     * @return void
     */
    public static function addRecord(Model $obj,$evt,$type,$remark='')
    {
        $record = new self;
        if(Auth::check()){
            $record->user_id = Auth::user()->id;
        }
        $record->user_id = 0;
        $record->target_id = $obj->id;
        $record->target_model_name = get_class($obj);
        $record->evt = $evt;
        $record->type = $type;

        if(is_array($remark)){
            $str = '';
            foreach ($remark as $k=>$v){
                $str = $str . "'$k'" . '值变更为' . "'$v'" . ';';
            }
            $remark = $str;
        }
        $record->remark = $remark;
        $record->save();
    }

    /*1.用户；2.仓库；3.仓区；4.仓位；5.供应商；6.物流；7.采购订单；8.采购退货；9.入库；10.出库；11.调拨单；12.订单；13.商品；14.SKU；*/
    public function getTypeValAttribute()
    {
        switch ($this->type){
            case 1:
                $value = '用户';
                break;
            case 2:
                $value = '仓库';
                break;
            case 3:
                $value = '仓区';
                break;
            case 4:
                $value = '仓位';
                break;
            case 5:
                $value = '供应商';
                break;
            case 6:
                $value = '物流';
                break;
            case 7:
                $value = '采购订单';
                break;
            case 8:
                $value = '采购退货';
                break;
            case 9:
                $value = '入库';
                break;
            case 10:
                $value = '出库';
                break;
            case 11:
                $value = '调拨单';
                break;
            case 12:
                $value = '订单';
                break;
            case 13:
                $value = '商品';
                break;
            case 14:
                $value = 'SKU';
                break;
        }
        return $value;
    }

    /*行为：1.创建；2.编辑；3.删除；4.审核；5.反审；6.发货*/
    public function getEvtValAttribute()
    {
        switch ($this->evt){
            case 1;
                $value = '创建';
                break;
            case 2;
                $value = '编辑';
                break;
            case 3;
                $value = '删除';
                break;
            case 4;
                $value = '审核';
                break;
            case 5;
                $value = '反审';
                break;
            case 6;
                $value = '发货';
                break;
        }
        return $value;
    }

    /**
     * 根据关联ID target_id 与 关联model类名 添加
     * @param $value
     * @return $name|$title|$number|$value
     */
    public function getTargetIdValAttribute()
    {
        $model_name = $this->target_model_name;
        $model = $model_name::find($this->target_id);
        if($name = $model->name){
            return $name;
        }

        if($title = $model->title){
            return $title;
        }

        if($number = $model->number){
            return $number;
        }
        return $value;
    }
}
