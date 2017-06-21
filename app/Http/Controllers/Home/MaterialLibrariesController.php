<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Models\MaterialLibrariesModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Qiniu\Auth;

class MaterialLibrariesController extends Controller
{

    //七牛回调方法
    public function callback(Request $request)
    {
        $post = $request->all();
        $imageData = [];
        $imageData['name'] = $post['name'];
        $imageData['size'] = $post['size'];
        $imageData['width'] = $post['width'];
        $imageData['height'] = $post['height'];
        $imageData['mime'] = $post['mime'];
        $imageData['domain'] = config('qiniu.domain');
        $key = uniqid();
        $imageData['path'] = config('qiniu.domain') . '/' .date("Ymd") . '/' . $key;
        if($materialLibraries = MaterialLibrariesModel::create($imageData)){
            $id = $materialLibraries->id;
            $callBackDate = [
                'key' => $materialLibraries->path,
                'payload' => [
                    'success' => 1,
                    'name' => config('qiniu.material_url').$materialLibraries->path,
                    'small' => config('qiniu.material_url').$materialLibraries->path.config('qiniu.small'),
                    'material_id' => $id
                ]
            ];
            return response()->json($callBackDate);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageIndex($id)
    {
        $product = ProductsModel::where('id' , (int)$id)->first();
        $materialLibraries = MaterialLibrariesModel::where('product_number' , $product->number)->where('type' , 1)->get();

        return view('home/materialLibraries.materialLibrary',[
            'materialLibraries' => $materialLibraries,
            'type' => 1,
            'product_id' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageCreate($id)
    {
        $product = ProductsModel::where('id' , $id)->first();
        $product_number = $product->number;
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        return view('home/materialLibraries.create',[
            'token' => $token,
            'product_number' => $product_number
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imageStore(Request $request)
    {
        $product_number = $request->input('product_number');
        $product = ProductsModel::where('number' , $product_number)->first();
        $id = $product->id;
        if($product){
            $materialLibrary = new MaterialLibrariesModel();
            $materialLibrary->product_number = $product_number;
            $materialLibrary->type = 1;
            if($materialLibrary->save()){
                return redirect()->action('Home\MaterialLibrariesController@imageIndex', ['product_id' => $id]);
            }
        }else{
            return "添加失败";
        }
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
