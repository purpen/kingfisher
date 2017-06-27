<?php

namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\StorageSkuCountTransformer;
use App\Models\StorageSkuCountModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class storageSkuCountController extends BaseController
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
     * @api {get} /saasApi/storageSkuCount 按库存
     * @apiVersion 1.0.0
     * @apiName storageSkuCount lists
     * @apiGroup storageSkuCount
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     */
    public function show(Request $request)
    {
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page ;
        $storageSkuCounts = StorageSkuCountModel
            ::orderBy('count', 'asc')
            ->paginate($per_page);
        return $this->response->paginator($storageSkuCounts, new StorageSkuCountTransformer())->setMeta(ApiHelper::meta());

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
