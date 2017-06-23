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
        $imageData = $request->all();
        foreach($imageData as &$value){
            if(empty($value)){
                unset($value);
            }
        }
        $imageData['domain'] = config('qiniu.domain');
        $key = uniqid();
        $imageData['path'] = config('qiniu.saas_domain') . '/' .date("Ymd") . '/' . $key;

        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);
        //获取回调的body信息
        $callbackBody = file_get_contents('php://input');
        $body = json_decode($callbackBody, true);
        //回调的contentType
        $contentType = 'application/x-www-form-urlencoded';
        //回调的签名信息，可以验证该回调是否来自七牛
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        //七牛回调的url，具体可以参考
        $url = config('qiniu.material_call_back_url');
        $isQiniuCallback = $auth->verifyCallback($contentType, $authorization, $url, $callbackBody);


        if ($isQiniuCallback) {
            $materialLibraries = new MaterialLibrariesModel();
            $materialLibraries->fill($imageData);
            if($materialLibraries->save()) {
                $callBackDate = [
                    'key' => $materialLibraries->path,
                    'payload' => [
                        'success' => 1,
                        'name' => config('qiniu.material_url').$materialLibraries->path,
                        'small' => config('qiniu.material_url').$materialLibraries->path.config('qiniu.small'),
                    ]
                ];
                return response()->json($callBackDate);
            }
        } else {
            $callBackDate = [
                'error' => 2,
                'message' => '上传失败'
            ];
            return response()->json($callBackDate );
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

        return view('home/materialLibraries.image',[
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
        return view('home/materialLibraries.imageCreate',[
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

            $materialLibraries = MaterialLibrariesModel::where('product_number' , $product_number )->get();
            foreach ($materialLibraries as $materialLibrary){
                $materialLibrary->product_number = $product_number;
                $materialLibrary->type = 1;
                if($materialLibrary->save()){
                    return redirect()->action('Home\MaterialLibrariesController@imageIndex', ['product_id' => $id]);
                }
            }
        }else{
            return "添加失败";
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function videoIndex($id)
    {
        $product = ProductsModel::where('id' , (int)$id)->first();
        $materialLibraries = MaterialLibrariesModel::where('product_number' , $product->number)->where('type' , 1)->get();

        return view('home/materialLibraries.video',[
            'materialLibraries' => $materialLibraries,
            'type' => 2,
            'product_id' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function videoCreate($id)
    {
        $product = ProductsModel::where('id' , $id)->first();
        $product_number = $product->number;
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        return view('home/materialLibraries.videoCreate',[
            'token' => $token,
            'product_number' => $product_number
        ]);
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
