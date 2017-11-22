<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class DistributorController extends BaseController
{

    /**
     * @api {get} /MicroApi/distributor 分销商详情
     * @apiVersion 1.0.0
     * @apiName Distributors distributor
     * @apiGroup Distributors
     *
     * @apiParam {integer} distributor_id 分销商id
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {

            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function product(Request $request)
    {
        $distributor_id = $request->input('distributor_id');
        $distributor = UserModel::where('id' , $distributor_id)->where('type' , 1)->first();

        if (!$distributor) {
            return $this->response->array(ApiHelper::error('not found', 404));
        }

        return $this->response->item($distributor, new DistributorTransformer())->setMeta(ApiHelper::meta());

    }



}
