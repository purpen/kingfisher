<?php

namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\ProductsTransformer;
use App\Models\OrderSkuRelationModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @api {get} /saasApi/products 按商品数量
     * @apiVersion 1.0.0
     * @apiName Products lists
     * @apiGroup Products
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     */
    public function show(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page ;

        $sku_list = OrderSkuRelationModel
            ::select(DB::raw('sum(quantity * price) as sale_money,sum(quantity) as count,id,sku_id,sku_number,product_id'))
            ->where('refund_status','=', 0)
            ->groupBy('sku_id')
            ->orderBy('count','desc')
            ->paginate($per_page);
        return $this->response->paginator($sku_list, new ProductsTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
