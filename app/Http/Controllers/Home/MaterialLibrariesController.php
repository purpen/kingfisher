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
use Qiniu\Storage\BucketManager;

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
        $imageData['domain'] = config('qiniu.saas_domain');
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
        $random = uniqid();
        $material_upload_url = config('qiniu.material_upload_url');
        return view('home/materialLibraries.imageCreate',[
            'token' => $token,
            'product_number' => $product_number,
            'random' => $random,
            'material_upload_url' => $material_upload_url,
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
        dd($request->all());
        $product_number = $request->input('product_number');
        $describe = $request->input('describe');
        $product = ProductsModel::where('number' , $product_number)->first();
        $id = $product->id;
        if($product){
            $materialLibraries = MaterialLibrariesModel::where('random' , $request->input('random') )->get();
            foreach ($materialLibraries as $materialLibrary){
                $materialLibrary->product_number = $product_number;
                $materialLibrary->describe = $describe;
                $materialLibrary->type = 1;
                $materialLibrary->save();
            }
            return redirect()->action('Home\MaterialLibrariesController@imageIndex', ['product_id' => $id]);
        }else{
            return "添加失败";
        }
    }

    //删除图片
    public function ajaxDelete(Request $request)
    {
        $id = $request->input('id');
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');

        //初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);

        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);

        //你要测试的空间， 并且这个key在你空间中存在
        $bucket = config('qiniu.material_bucket_name');

        if($asset = MaterialLibrariesModel::find($id)){
            $key = $asset->path;
        }else{
            exit('图片不存在');
        }


        //删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        if ($err !== null) {
            Log::error($err);
        } else {
            if(AssetsModel::destroy($id)){
                return ajax_json(1,'图片删除成功');
            }else{
                return ajax_json(0,'图片删除失败');
            }
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
