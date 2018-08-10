<?php

namespace App\Http\SaasTransformers;

use App\Models\LogisticsModel;
use League\Fractal\TransformerAbstract;

class LogisticsTransformer extends TransformerAbstract
{
    /**
    id	int(11)	否
    jd_logistics_id	varchar(20)	否		京东平台物流代码
    tb_logistics_id	varchar(20)	否		淘宝平台物流代码
    zy_logistics_id	varchar(20)	否		自营平台物流代码
    kdn_logistics_id	varchar(20)	否		快递鸟物流代码
    name	varchar(50)	否		公司名称
    area	varchar(50)	是		所属子公司(区域)
    contact_user	varchar(15)	否		联系人
    contact_number	varchar(15)	否		联系电话
    summary	varchar(500)	是		备注
    user_id	int(11)	否		用户ID
    status	tinyint(1)	否		状态：0.禁用；1.正常
     */
    public function transform(LogisticsModel $logistics)
    {
        return [
            'id' => $logistics->id,
            'jd_logistics_id' => $logistics->jd_logistics_id,
            'tb_logistics_id' => $logistics->tb_logistics_id,
            'zy_logistics_id' => $logistics->zy_logistics_id,
            'kdn_logistics_id' => $logistics->kdn_logistics_id,
            'name' => $logistics->name,
            'area' => $logistics->area,
            'contact_user' => $logistics->contact_user,
            'contact_number' => $logistics->contact_number,
            'summary' => $logistics->summary,
            'user_id' => $logistics->user_id,
            'status' => $logistics->status,

        ];
    }
}
