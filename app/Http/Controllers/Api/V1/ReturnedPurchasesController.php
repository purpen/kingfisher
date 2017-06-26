<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\returnedPurchaseTransformer;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReturnedPurchasesController extends BaseController
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
     * @api {get} /api/returnedPurchases 采购退货订单展示
     * @apiVersion 1.0.0
     * @apiName returnedPurchases lists
     * @apiGroup returnedPurchases
     *
     * @apiParam {string} token token
     * @apiParam {string} start_date 开始时间 例:20170615
     * @apiParam {string} end_date 结束时间 例:20170618
     * @apiParam {string} random_id 供应商编号
     */
    public function lists(Request $request)
    {
        $time = null;
        $start_date = null;
        $end_date = null;

        if($request->isMethod('get')){
            if($request->input('start_date')){
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
            }else{
                $time = $request->input('time')?(int)$request->input('time'):365;
                $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
                $end_date = date("Y-m-d H:i:s");
            }
        }

        if($request->isMethod('post')){
            $start_date = date("Y-m-d H:i:s",strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s",strtotime($request->input('end_date')));
        }
        $random_id = $request->input('random_id');
        if(!empty($random_id)){
            $suppliers = SupplierModel::where('random_id' , $random_id)->first();
            if(!$suppliers){
                return $this->response->array(ApiHelper::error('没有找到该供应商', 404));
            }
            $sup_id = $suppliers->id;
            $returnedPurchase = DB::table('returned_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'returned_sku_relation.sku_id')
                ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
                ->join('returned_purchases', 'returned_purchases.id', '=', 'returned_sku_relation.returned_id')
                ->select('returned_purchases.*', 'returned_purchases.number as returned_purchases_number','returned_sku_relation.*' , 'products_sku.*', 'products.*' )
                ->whereBetween('returned_purchases.created_at', [$start_date , $end_date])
                ->where('products.supplier_id' , '=' ,(int)$sup_id)
                ->get();
        }else{
            $returnedPurchase = DB::table('returned_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'returned_sku_relation.sku_id')
                ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
                ->join('returned_purchases', 'returned_purchases.id', '=', 'returned_sku_relation.returned_id')
                ->select('returned_purchases.*', 'returned_purchases.number as returned_purchases_number','returned_sku_relation.*' , 'products_sku.*', 'products.*' )
                ->whereBetween('returned_purchases.created_at', [$start_date , $end_date])
                ->get();
        }
        $returnedPurchases = collect($returnedPurchase);
        dd($returnedPurchases);
        return $this->response->collection($returnedPurchases, new returnedPurchaseTransformer())->setMeta(ApiHelper::meta());
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
