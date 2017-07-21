<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Models\Feedback;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FeedbackController extends BaseController
{
    /**
     * @api {post} /saasApi/feedback/store 意见反馈提交
     * @apiVersion 1.0.0
     * @apiName Feedback store
     * @apiGroup Feedback
     *
     * @apiParam {string} content 内容
     * @apiParam {string} contact 联系方式
     * @apiParam {string} token
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
        $all = $request->all();

        $rules = [
            'content' => 'required|max:500',
            'contact' => 'max:50',
        ];

        $massage = [
            'content.required' => '内容不能为空',
            'content.max' => '不能超过500字',
            'contact.max' => '不能超过50字符'
        ];

        $validator = Validator::make($all, $rules, $massage);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        $feedback = new Feedback();
        $feedback->content = $all['content'];
        if(array_key_exists('contact', $all)){
            $feedback->contact = $all['contact'];
        }
        $feedback->user_id = $this->auth_user_id;
        $feedback->save();

        return $this->response->array(ApiHelper::success());
    }
}