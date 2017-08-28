<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use Illuminate\Http\Request;
use App\Http\SaasTransformers\CityTransformer;
use App\Models\ChinaCityModel;

class ChinaCityController extends BaseController
{

    /**
     * @api {get} /city 城市省份列表
     * @apiVersion 1.0.0
     * @apiName City cities
     * @apiGroup City
     *
     * @apiParam {string} token token
     */
    public function city()
    {
        $china_city = ChinaCityModel::where('layer',1)->get();
        return $this->response()->collection($china_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /fetchCity 根据省份查看下级城市的列表
     * @apiVersion 1.0.0
     * @apiName City fetchCity
     * @apiGroup City
     *
     * @apiParam {integer} oid 唯一（父id）
     * @apiParam {integer} layer 级别（子id）
     * @apiParam {string} token token
     */
    public function fetchCity(Request $request)
    {
        $oid = (int)$request->input('oid');
        $layer = (int)$request->input('layer');
        $chinaModel = new ChinaCityModel();
        $fetch_city = $chinaModel->fetchCity($oid,$layer);
        return $this->response()->collection($fetch_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }
}