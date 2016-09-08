<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ProvinceModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'province';

    public $timestamps = false;

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','type','status'];

    /**
     * 类型说明
     * @var int
     * @return string
     */
    public function type_label($type)
    {
        switch((int)$type){
            case 1:
                return '直辖市';
                break;
            case 2:
                return '行政省';
                break;
            case 3:
                return '自治区';
                break;
            case 4:
                return '特别行政区';
                break;
            case 5:
                return '其它国家';
                break;
            default:
                return '--';
        }
    }


}
