<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\FileRecordsTransformer;
use App\Models\FileRecordsModel;
use App\Models\SiteModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use App\Http\SaasTransformers\SiteListTransformer;
use App\Http\SaasTransformers\SiteTransformer;


class FileRecordsController extends BaseController
{
    /**
     * @api {get} /saasApi/fileRecords 订单导入记录列表
     * @apiVersion 1.0.0
     * @apiName fileRecords lists
     * @apiGroup fileRecords
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
    {
        "data": [
            {
                "id": 112,
                "user_id": 1,
                "file_name": "太火鸟zyy new new.xlsx", //文件名称
                "status": 1, //状态0进行中。1已完成
                "total_count": 3, //总条数
                "success_count": 1, //成功数
                "no_sku_count": 0, //没有sku的数量
                "no_sku_string": "", //没有sku的订单号
                "repeat_outside_count": 2, //重复的数
                "repeat_outside_string": "ZY000001,ZY000002", //重复的订单号
                "null_field_count": 0, //空字段的数
                "null_field_string": "", //空字段的订单号
                "sku_storage_quantity_count": 0, //sku库存不足的数
                "sku_storage_quantity_string": "" //库存不足的订单号
            },
            {
                "id": 111,
                "user_id": 1,
                "file_name": "太火鸟zyy.csv",
                "status": 1,
                "total_count": 2,
                "success_count": 2,
                "no_sku_count": 0,
                "no_sku_string": "",
                "repeat_outside_count": 0,
                "repeat_outside_string": "",
                "null_field_count": 0,
                "null_field_string": "",
                "sku_storage_quantity_count": 0,
                "sku_storage_quantity_string": ""
            }
        ],
        "meta": {
            "message": "Success.",
            "status_code": 200,
            "pagination": {
                "total": 2,
                "count": 2,
                "per_page": 10,
                "current_page": 1,
                "total_pages": 1,
                "links": []
            }
        }
    }
     */
    public function lists(Request $request)
    {
        $user_id = $this->auth_user_id;
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $file_records = FileRecordsModel::where('user_id' , $user_id)->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($file_records, new FileRecordsTransformer())->setMeta(ApiHelper::meta());
    }



}
