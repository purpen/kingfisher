<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\CategoryTransformer;
use App\Http\DealerTransformers\CityTransformer;
use App\Models\ChinaCityModel;
use Illuminate\Http\Request;

class OrderController extends BaseController{

    /**
     * @api {get} /DealerApi/order/city 省份列表
     * @apiVersion 1.0.0
     * @apiName Order cities
     * @apiGroup Order
     *
     * @apiParam {string} token token
     */
    public function city()
    {
        $china_city = ChinaCityModel::where('layer',1)->get();
        return $this->response()->collection($china_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /DealerApi/order/fetchCity 城市列表
     * @apiVersion 1.0.0
     * @apiName Order fetchCity
     * @apiGroup Order
     *
     * @apiParam {integer} oid 唯一（父id）
     * @apiParam {integer} layer 级别（子id）2
     * @apiParam {string} token token
     */
    public function fetchCity(Request $request)
    {
        $oid = (int)$request->input('value');
        $layer = (int)$request->input('layer');
        $chinaModel = new ChinaCityModel();
        $fetch_city = $chinaModel->fetchCity($oid,$layer);

        if ($layer == 1){
            $fetch_city = ChinaCityModel::where('layer',1)->where('oid',$oid)->first();
        }

        return $this->response()->collection($fetch_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }
}