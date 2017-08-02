<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Models\SiteRecordModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use App\Http\SaasTransformers\SiteRecordListTransformer;
use App\Http\SaasTransformers\SiteRecordTransformer;
use Illuminate\Support\Facades\Validator;


class SiteRecordController extends BaseController
{
    /**
     * @api {get} /saasApi/site_record/getList 网站记录列表
     * @apiVersion 1.0.0
     * @apiName site_record lists
     * @apiGroup Site
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} site_type 网站类型
     * @apiParam {string} mark 网站标识
     *
     * @apiSuccess {string} url 网站地址
     * @apiSuccess {integer} site_type 网站类型: 1.公众号； 2.众筹；3.普通销售；4.--
     * @apiSuccess {string} mark 标识
     * @apiSuccess {integer} count 数量
     * @apiSuccess {integer} status 状态: 0.禁用；1.启用；
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 4,
                    "mark": "jd_zc",
                    "url": "www.jd.com",
                    "site_type": 1,
                    "count": 33,
                    "status": 1
                },
                {
                    "id": 5,
                    "mark": "yitiao",
                    "url": "www.yt.com",
                    "site_type": 2,
                    "count": 100,
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
        $mark = $request->input('mark') ? $request->input('mark') : '';
        $query = array();
        if($site_type){
          $query['site_type'] = $site_type;
        }
        if($mark){
          $query['mark'] = $mark;
        }
        $lists = SiteRecordModel::where($query)
            ->orderBy('id', 'desc')
            ->paginate($per_page);

        return $this->response->paginator($lists, new SiteRecordListTransformer)->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/site_record/show 站点记录详情
     * @apiVersion 1.0.0
     * @apiName Site show
     * @apiGroup Site
     *
     * @apiParam {integer} id ID
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 2,
                "mark": "jd_zc",    // 网站唯一标识
                "url": "http://www.jd.com",   // 网址记录
                "count": 3,       // 数量
                "status": 1,   // 状态：0.关闭；1.开启；
                "site_type": 1      // 网站类型
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

        $query = array();
        if(!empty($id)) {
            $query['id'] = $id;
        } else {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 500));       
        }

        $site = SiteRecordModel::where($query)->first();
        if (!$site) {
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        return $this->response->array(ApiHelper::success('Success', 200, $site));
    }

    /**
     * @api {post} /saasApi/site_record/store 创建网址记录
     * @apiVersion 1.0.0
     * @apiName site_record store
     * @apiGroup Site
     *
     * @apiParam {string} mark 标识
     * @apiParam {string} url 网址
     * @apiParam {integer} site_type 类型
     * @apiParam {integer} count 数量
     * @apiParam {integer} status 状态
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function store(Request $request)
    {
        $data = array(
          'url' => $request->input('url'),
          'mark' => $request->input('mark'),
          'site_type' => $request->input('site_type') ? (int)$request->input('site_type') : 1,
          'count' => $request->input('count') ? (int)$request->input('count') : 0,
          'status' => $request->input('status') ? (int)$request->input('status') : 0,
        );


        $rules = [
            'url' => 'required|max:1000',
            'mark' => 'required|max:20'
        ];

        $massage = [
            'url.required' => '地址不能为空',
            'url.max' => '地址不能超过1000字',
            'mark.required' => '标识不能为空',
            'mark.max' => '标识不能超过20字符'
        ];

        $validator = Validator::make($data, $rules, $massage);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }
        $ok = SiteRecordModel::create($data);
        if(!$ok) {
            return $this->response->array(ApiHelper::error('创建失败！', 500));       
        }

        return $this->response->array(ApiHelper::success());
    }

    /**
     * @api {post} /saasApi/site_record/remove 删除网址记录
     * @apiVersion 1.0.0
     * @apiName site_record remove
     * @apiGroup Site
     *
     * @apiParam {integer} id ID
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function remove(Request $request)
    {
        $id = $request->input('id');
        if(!$id) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 500));        
        }
        $ok = SiteRecordModel::destroy($id);
        if(!$ok){
            return $this->response->array(ApiHelper::error('删除失败！', 500)); 
        }

        return $this->response->array(ApiHelper::success());
    }

}
