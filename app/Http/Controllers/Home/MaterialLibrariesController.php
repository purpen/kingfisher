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
        } else {
            $callBackDate = [
                'error' => 2,
                'message' => '上传失败'
            ];
            return response()->json($callBackDate );
        }
    }

    /**
     * 异步处理通知
     */
    public function qiniuNotify(Request $request)
    {
        Log::warning('Qiniu Notify!!!');

        $param = file_get_contents('php://input');

        Log::warning($param);

        $body = json_decode($param, true);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageIndex()
    {
        $materialLibraries = MaterialLibrariesModel::where('type' , 1)->paginate(15);
        return view('home/materialLibraries.image',[
            'materialLibraries' => $materialLibraries,
            'type' => 1,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageCreate()
    {
        $products = ProductsModel::where('saas_type' , 1)->get();
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        $random = uniqid();
        $material_upload_url = config('qiniu.material_upload_url');
        return view('home/materialLibraries.imageCreate',[
            'token' => $token,
            'products' => $products,
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
        $product_number = $request->input('product_number');
        $describe = $request->input('describe');
        $image_type = $request->input('image_type');
        $product = ProductsModel::where('number' , $product_number)->first();
        $id = $product->id;
        if($product){
            $materialLibraries = MaterialLibrariesModel::where('random' , $request->input('random') )->get();
            foreach ($materialLibraries as $materialLibrary){
                $materialLibrary->product_number = $product_number;
                $materialLibrary->describe = $describe;
                $materialLibrary->image_type = $image_type;
                $materialLibrary->type = 1;
                $materialLibrary->save();
            }
            return redirect()->action('Home\MaterialLibrariesController@imageIndex', ['product_id' => $id]);
        }else{
            return "添加失败";
        }
    }

    //编辑图片
    public function imageEdit($id)
    {
        $materialLibrary = MaterialLibrariesModel::where('id' , $id)->first();
        $products = ProductsModel::where('saas_type' , 1)->get();
        $random = uniqid();
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        $material_upload_url = config('qiniu.material_upload_url');
        return view('home/materialLibraries.imageEdit',[
            'token' => $token,
            'materialLibrary' => $materialLibrary,
            'random' => $random,
            'material_upload_url' => $material_upload_url,
            'products' => $products,
        ]);

    }

    //更改图片
    public function imageUpdate(Request $request)
    {
        $id = (int)$request->input('materialLibrary_id');
        $materialLibrary = MaterialLibrariesModel::find($id);
        $product_number = $request->input('product_number');
        $product_id = ProductsModel::where('number' , $product_number)->first();
        if($materialLibrary->update($request->all())){
            return redirect()->action('Home\MaterialLibrariesController@imageIndex', ['product_id' => $product_id]);
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
            if(MaterialLibrariesModel::destroy($id)){
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
    public function videoIndex()
    {
        $materialLibraries = MaterialLibrariesModel::where('type' , 2)->paginate(15);

        return view('home/materialLibraries.video',[
            'materialLibraries' => $materialLibraries,
            'type' => 2,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function videoCreate()
    {
        $products = ProductsModel::where('saas_type' , 1)->get();
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        $random = uniqid();
        $material_upload_url = config('qiniu.material_upload_url');
        return view('home/materialLibraries.videoCreate',[
            'token' => $token,
            'random' => $random,
            'material_upload_url' => $material_upload_url,
            'products' => $products,
        ]);
    }

    public function videoStore(Request $request)
    {
        $product_number = $request->input('product_number');
        $describe = $request->input('describe');
        $product = ProductsModel::where('number' , $product_number)->first();
        $id = $product->id;
        if($product){
            $materialLibraries = MaterialLibrariesModel::where('random' , $request->input('random') )->get();
            foreach ($materialLibraries as $materialLibrary){
                $materialLibrary->product_number = $product_number;
                $materialLibrary->describe = $describe;
                $materialLibrary->type = 2;
                $materialLibrary->save();
            }
            return redirect()->action('Home\MaterialLibrariesController@videoIndex', ['product_id' => $id]);
        }else{
            return "添加失败";
        }
    }

    //视频编辑
    public function videoEdit($id)
    {
        $materialLibrary = MaterialLibrariesModel::where('id' , $id)->first();
        $product_number = $materialLibrary->product_number;
        $random = uniqid();
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        $material_upload_url = config('qiniu.material_upload_url');
        $materialLibrary->videoPath = config('qiniu.material_url').$materialLibrary->path;
        return view('home/materialLibraries.videoEdit',[
            'token' => $token,
            'materialLibrary' => $materialLibrary,
            'random' => $random,
            'material_upload_url' => $material_upload_url,
            'product_number' => $product_number,
        ]);
    }

    //更改视频
    public function videoUpdate(Request $request)
    {
        $id = (int)$request->input('materialLibrary_id');
        $materialLibrary = MaterialLibrariesModel::find($id);
        $product_number = $request->input('product_number');
        $product_id = ProductsModel::where('number' , $product_number)->first();
        if($materialLibrary->update($request->all())){
            return redirect()->action('Home\MaterialLibrariesController@videoIndex', ['product_id' => $product_id]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function describeIndex()
    {
        $materialLibraries = MaterialLibrariesModel::where('type' , 3)->paginate(15);

        return view('home/materialLibraries.describe',[
            'materialLibraries' => $materialLibraries,
            'type' => 3,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function describeCreate()
    {
        $products = ProductsModel::where('saas_type' , 1)->get();

        //获取七牛上传token
        return view('home/materialLibraries.describeCreate',[
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function describeStore(Request $request)
    {
        $product_number = $request->input('product_number');
        $describe = $request->input('describe');
        $product = ProductsModel::where('number' , $product_number)->first();
        $id = $product->id;
        if($product){
            $materialLibrary = new MaterialLibrariesModel();
            $materialLibrary->product_number = $product_number;
            $materialLibrary->describe = $describe;
            $materialLibrary->type = 3;
            $materialLibrary->save();
            return redirect()->action('Home\MaterialLibrariesController@describeIndex', ['product_id' => $id]);
        }else{
            return redirect()->action('Home\MaterialLibrariesController@describeIndex', ['product_id' => $id])->with('error_message', '添加失败!');
        }
    }

    //文字编辑
    public function describeEdit($id)
    {
        $materialLibrary = MaterialLibrariesModel::where('id' , $id)->first();
        $product_number = $materialLibrary->product_number;
        return view('home/materialLibraries.describeEdit',[
            'materialLibrary' => $materialLibrary,
            'product_number' => $product_number,
        ]);
    }

    //文字更改
    public function describeUpdate(Request $request)
    {
        $id = (int)$request->input('materialLibrary_id');
        $materialLibrary = MaterialLibrariesModel::find($id);
        $product_number = $request->input('product_number');
        $product_id = ProductsModel::where('number' , $product_number)->first();
        if($materialLibrary->update($request->all())){
            return redirect()->action('Home\MaterialLibrariesController@describeIndex', ['product_id' => $product_id]);
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
