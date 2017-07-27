<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Models\SiteModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use App\Http\SaasTransformers\SiteListTransformer;
use App\Http\SaasTransformers\SiteTransformer;


class SiteController extends BaseController
{
    /**
     * @api {get} /saasApi/site/getList 站点列表
     * @apiVersion 1.0.0
     * @apiName site lists
     * @apiGroup Site
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} site_type 网站类型: 1.公众号； 2.众筹；3.普通销售；4.--
     * @apiParam {integer} user_id 供应商ID
     * @apiParam {integer} status 状态: 0.禁用；1.启用；
     *
     * @apiSuccess {integer} site_type 网站类型: 1.公众号； 2.众筹；3.普通销售；4.--
     * @apiSuccess {string} mark 标识
     * @apiSuccess {string} name 网站名称
     * @apiSuccess {string} url 网址
     * @apiSuccess {string} grap_url 爬取地址
     * @apiSuccess {integer} status 状态: 0.禁用；1.启用；
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 4,
                    "name": "京东众筹",
                    "mark": "jd_zc",
                    "url": "www.jd.com",
                    "grap_url": "www.jd.com/abc?a=aaa1",
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
                    "grap_url": "www.jd.com/abc?a=aaa1",
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
        $user_id = $request->input('user_id') ? (int)$request->input('user_id') : 0;
        $query = array();
        if($site_type){
          $query['site_type'] = $site_type;
        }
        if($user_id){
          $query['user_id'] = $user_id;
        }
        $lists = SiteModel::where($query)
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($lists, new SiteListTransformer)->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/site/show 站点详情
     * @apiVersion 1.0.0
     * @apiName Site show
     * @apiGroup Site
     *
     * @apiParam {integer} id ID
     * @apiParam {string} mark 标识
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 2,
                "mark": "jd_zc",    // 网站唯一标识
                "name": "京东众筹", // 网站名称
                "url": "http://www.jd.com",   // 网站
                "grap_url": "www.jd.com/abc?a=aaa1",
                "user_id": 3,       // 用户ID
                "items": [
                    {
                        "field": "url",   // 字段名
                        "name": "网站",   // 说明
                        "code": "aaaaa",  // 配置
                    },
                    {
                        "field": "content",   // 字段名
                        "name": "内容",   // 说明
                        "code": "bbbb",  // 配置
                    },
                ],
                "status": 1,   // 状态：0.关闭；1.开启；
                "site_type": 1      // 网站类型：1.公众号；2.众筹；3.普通销售；
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     **/
    public function show(Request $request)
    {
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        $mark = $request->input('mark') ? $request->input('mark') : '';

        $query = array();
        if(!empty($id)) {
            $query['id'] = $id;
        } elseif(!empty($mark)) {
            $query['mark'] = $mark;
        } else {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 500));       
        }

        $site = SiteModel::where($query)->first();
        if (!$site) {
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        return $this->response->array(ApiHelper::success('Success', 200, $site));
    }

}
