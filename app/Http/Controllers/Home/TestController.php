<?php

namespace App\Http\Controllers\Home;

use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jdCalllback(Request $request)
    {
        Log::write('info', 'Test jd_callback!!!!');
        Log::write('info', json_encode($request->input()));
        echo "123";
        //return view('home.index');
    }

    //通过商品和商品sku 通过number，建立已product_id 关联,脚本
    public function productAndSku(){
        $productSkus = ProductsSkuModel::where('id','>','1740')->get();
        foreach ($productSkus as $productSku){
            $product_number = $productSku->product_number;
            $id = ProductsModel::where('number',$product_number)->first()->id;
//            dd($id);
            $productSku->product_id = $id;
            $productSku->save();
        }
        return "okokok";
    }
    
    public function productAndSupplier(){
        $products = ProductsModel::where('id','>',1137)->get();
        foreach ($products as $product) {
            $name = $product->supplier_name;
            $id = SupplierModel::where('nam',$name)->first();
            if(!$id){
                continue;
            }
            $id = $id->id;
            $product->supplier_id = $id;
            $product->save();
        }
        return 'okokok';
    }

}
