<?php
namespace App\Http\Controllers\Api\SaasV1;


use App\Http\ApiHelper;
use App\Models\OrderModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends BaseController
{

    /**
     * @api {post} /saasApi/order/excel 订单导入
     * @apiVersion 1.0.0
     * @apiName Order excel
     * @apiGroup Order
     *
     * @apiParam {integer} store_id 店铺id
     * @apiParam {integer} product_id 商品id   product_type类型为1的商品是众筹商品
     * @apiParam {file} file 文件
     */
    public function excel(Request $request)
    {
        $store_id = $request->input('store_id');
        $product_id = $request->input('product_id');
        if(empty($store_id)){
            return $this->response->array(ApiHelper::error('店铺id不能为空', 200));

        }
        if(empty($product_id)){
            return $this->response->array(ApiHelper::error('商品id不能为空', 200));

        }
        $product = ProductsModel::where('id' , $product_id)->first();
        $product_number = $product->number;
        if(!$request->hasFile('file') || !$request->file('file')->isValid()){
            return $this->response->array(ApiHelper::error('上传失败', 401));
        }
        $file = $request->file('file');
        //读取execl文件
        $results = Excel::load($file, function($reader) {
        })->get();
        dd($results);

        $results = $results->toArray();

        DB::beginTransaction();
        $new_data = [];
        foreach ($results as $data)
        {
            if(!empty($data['档位价格']) && !in_array($data['档位价格'] , $new_data)){
                $sku_number  = 1;
                $sku_number .= date('ymd');
                $sku_number .= sprintf("%05d", rand(1,99999));
                $product_sku = new ProductsSkuModel();
                $product_sku->product_id = $product_id;
                $product_sku->product_number = $product_number;
                $product_sku->number = $sku_number;
                $product_sku->price = $data['档位价格'];
                $product_sku->bid_price = $data['档位价格'];
                $product_sku->cost_price = $data['档位价格'];
                $product_sku->mode = '众筹款';
                $product_sku->save();
                $product_sku_id = $product_sku->id;
                $new_data[] = $product_sku->price;
            }else{
                $product_sku = ProductsSkuModel::where('price' , $data['档位价格'])->where('mode' , '众筹款')->first();
                $product_sku_id = $product_sku->id;
            }
            $result = OrderModel::zcInOrder($data , $store_id , $product_id , $product_sku_id);
            if(!$result[0]){
                DB::rollBack();
                return $this->response->array(ApiHelper::error('保存失败', 200));
            }
        }

        DB::commit();

        return $this->response->array(ApiHelper::success('保存成功', 200));

    }
}