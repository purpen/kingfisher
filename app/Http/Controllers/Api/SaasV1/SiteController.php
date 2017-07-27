<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Models\Site;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use App\Http\SaasTransformers\SiteListTransformer;
use App\Http\SaasTransformers\SiteTransformer;


class SiteController extends BaseController
{
    /**
     * @api {get} /saasApi/site/getList 列表
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary lists
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} product_id 商品id
     * @apiParam {string} token token
     *
     * @apiSuccess {integer} site_type 网站类型: 1.公众号； 2.众筹；3.普通销售；4.--
     * @apiSuccess {string} mark 标识
     * @apiSuccess {string} status 状态: 0.禁用；1.启用；
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 4,
                    "name": "京东众筹",
                    "mark": "jd_zc",
                    "url": "www.jd.com",
                    "site_type": 1,
                    "user_id": 3,
                    "remark": "备注",
                    "status": 1
                },
                {
                    "id": 5,
                    "name": "一条",
                    "mark": "yitiao",
                    "url": "www.yt.com",
                    "site_type": 2,
                    "user_id": 5,
                    "remark": "备注",
                    "status": 0
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
    public function getList(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $site_type = $request->input('site_type') ? (int)$request->input('site_type') : 0;
        $query = array();
        if($site_type){
          $query['site_type'] = $site_type;
        }
        if($user_id){
          $query['user_id'] = $user_id;
        }
        $lists = Site::where($query)
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($lists, new SiteListTransformer)->setMeta(ApiHelper::meta());
    }
}
