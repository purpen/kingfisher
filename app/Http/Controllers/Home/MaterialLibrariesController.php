<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Models\ArticleModel;
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
    public function imageIndex(Request $request)
    {
        $product_id = $request->input('id') ? $request->input('id') : '';
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!empty($product)){
            $product_number = $product->number;
        }else{
            $product_number = '';
        }

        if(!empty($product_number)){
            $materialLibraries = MaterialLibrariesModel::where('type' , 1)->where('product_number' , $product_number)->paginate(15);
        }else{
            $materialLibraries = MaterialLibrariesModel::where('type' , 1)->paginate(15);
        }
        return view('home/materialLibraries.image',[
            'materialLibraries' => $materialLibraries,
            'type' => 1,
            'search' => '',
            'product_id' => $product_id,

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
            'search' => '',
            'type' => 1,

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
        $product_id = $request->input('product_id');

        $describe = $request->input('describe');
        $image_type = $request->input('image_type');
        $materialLibraries = MaterialLibrariesModel::where('random' , $request->input('random') )->get();
        if($materialLibraries->count() == 0){
//            return back()->with('error_message', '请上传图片。')->withInput();
            return '请上传图片';
        }
        foreach ($materialLibraries as $materialLibrary){
            if(!empty($product_id)){
                $product = ProductsModel::where('id' , $product_id)->first();
                $materialLibrary->product_number = $product->number;
            }else{
                $materialLibrary->product_number = '';
            }
            $materialLibrary->describe = $describe;
            $materialLibrary->image_type = $image_type;
            $materialLibrary->type = 1;
            $materialLibrary->save();
        }
        return redirect('/saas/image');
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
            'search' => '',
            'type' => 1,

        ]);

    }

    //更改图片
    public function imageUpdate(Request $request)
    {
        $product = ProductsModel::where('id' , $request->input('product_id'))->first();
        $id = (int)$request->input('materialLibrary_id');
        $materialLibrary = MaterialLibrariesModel::find($id);
        if(!empty($product)){
            $materialLibrary['product_number'] = $product->number;
        }else{
            $materialLibrary['product_number'] = '';
        }
        if($materialLibrary->update($request->all())){
            return redirect('/saas/image');
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
    public function videoIndex(Request $request)
    {
        $product_id = $request->input('id') ? $request->input('id') : '';
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!empty($product)){
            $product_number = $product->number;
        }else{
            $product_number = '';
        }
        if(!empty($product_number)){
            $materialLibraries = MaterialLibrariesModel::where('type' , 2)->where('product_number' , $product_number)->paginate(15);
        }else{
            $materialLibraries = MaterialLibrariesModel::where('type' , 2)->paginate(15);
        }

        return view('home/materialLibraries.video',[
            'materialLibraries' => $materialLibraries,
            'type' => 2,
            'search' => '',
            'product_id' => $product_id,

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
            'search' => '',
            'type' => 2,

        ]);
    }

    public function videoStore(Request $request)
    {
        $product_id = $request->input('product_id');
        $describe = $request->input('describe');
        $materialLibraries = MaterialLibrariesModel::where('random' , $request->input('random') )->get();
        if($materialLibraries->count() == 0){
//            return back()->with('error_message', '请上传视频。')->withInput();
            return '请上传视频';
        }
        foreach ($materialLibraries as $materialLibrary){
            if(!empty($product_id)){
                $product = ProductsModel::where('id' , $product_id)->first();
                $materialLibrary->product_number = $product->number;
            }else{
                $materialLibrary->product_number = '';
            }
            $materialLibrary->describe = $describe;
            $materialLibrary->type = 2;
            $materialLibrary->save();
        }
        return redirect('/saas/video');

    }

    //视频编辑
    public function videoEdit($id)
    {
        $materialLibrary = MaterialLibrariesModel::where('id' , $id)->first();
        $random = uniqid();
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        $material_upload_url = config('qiniu.material_upload_url');
        $materialLibrary->videoPath = config('qiniu.material_url').$materialLibrary->path;
        $products = ProductsModel::where('saas_type' , 1)->get();
        return view('home/materialLibraries.videoEdit',[
            'token' => $token,
            'materialLibrary' => $materialLibrary,
            'random' => $random,
            'material_upload_url' => $material_upload_url,
            'products' => $products,
            'search' => '',
            'type' => 2,

        ]);
    }

    //更改视频
    public function videoUpdate(Request $request)
    {
        $product = ProductsModel::where('id' , $request->input('product_id'))->first();
        $id = (int)$request->input('materialLibrary_id');
        $materialLibrary = MaterialLibrariesModel::find($id);
        if(!empty($product)){
            $materialLibrary['product_number'] = $product->number;
        }else{
            $materialLibrary['product_number'] = '';
        }        if($materialLibrary->update($request->all())){
            return redirect('/saas/video');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function describeIndex(Request $request)
    {
        $product_id = $request->input('id') ? $request->input('id') : '';
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!empty($product)){
            $product_number = $product->number;
        }else{
            $product_number = '';
        }
        if(!empty($product_number)){
            $materialLibraries = MaterialLibrariesModel::where('type' , 3)->where('product_number' , $product_number)->paginate(15);
        }else{
            $materialLibraries = MaterialLibrariesModel::where('type' , 3)->paginate(15);
        }
        return view('home/materialLibraries.describe',[
            'materialLibraries' => $materialLibraries,
            'type' => 3,
            'search' => '',
            'product_id' => $product_id,

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
            'search' => '',
            'type' => 3,

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
        $product_id = $request->input('product_id');
        $materialLibrary = new MaterialLibrariesModel();
        $describe = $request->input('describe');
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!empty($product_id)){
            $materialLibrary->product_number = $product->number;
        }else{
            $materialLibrary->product_number = '';
        }
        $materialLibrary->describe = $describe;
        $materialLibrary->type = 3;
        if($materialLibrary->save()){
            return redirect('/saas/describe');
        }
    }

    //文字编辑
    public function describeEdit($id)
    {
        $materialLibrary = MaterialLibrariesModel::where('id' , $id)->first();
        $products = ProductsModel::where('saas_type' , 1)->get();
        return view('home/materialLibraries.describeEdit',[
            'materialLibrary' => $materialLibrary,
            'products' => $products,
            'search' => '',
            'type' => 3,

        ]);
    }

    //文字更改
    public function describeUpdate(Request $request)
    {
        $product = ProductsModel::where('id' , $request->input('product_id'))->first();
        $id = (int)$request->input('materialLibrary_id');
        $materialLibrary = MaterialLibrariesModel::find($id);
        if(!empty($product)){
            $materialLibrary['product_number'] = $product->number;
        }else{
            $materialLibrary['product_number'] = '';
        }
        if($materialLibrary->update($request->all())){
            return redirect('/saas/describe');
        }
    }

    //删除
    public function delete($id)
    {
        if(MaterialLibrariesModel::destroy($id)){
            return back()->withInput();
        }
    }

    //搜索
    public function search(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        //搜索商品，已开放的商品
        $products = ProductsModel::where('number' ,'like','%'. $search.'%')->orWhere('title' ,'like','%'. $search.'%')->where('saas_type' , 1)->get();
        if(!empty($products)){
            foreach ($products as $product){
                $number[] = $product->number;
            }
        }else{
            $number[] = '';
        }
        $product_number = $number;
        if(in_array($type , [1,2,3])){
            $materialLibraries = MaterialLibrariesModel::whereIn('product_number' , $product_number)->where('type' , $type)->paginate(15);
            if($type == 1){
                return view('home/materialLibraries.image',[
                    'materialLibraries' => $materialLibraries,
                    'type' => 1,
                    'search' => $search,
                ]);
            }
            if($type == 2){
                return view('home/materialLibraries.video',[
                    'materialLibraries' => $materialLibraries,
                    'type' => 2,
                    'search' => $search
                ]);
            }
            if($type == 3){
                return view('home/materialLibraries.describe',[
                    'materialLibraries' => $materialLibraries,
                    'type' => 3,
                    'search' => $search,
                ]);
            }
        }else{
            $articles = ArticleModel::where('product_number' , $product_number)->paginate(15);

            return view('home/article.article',[
                'articles' => $articles,
                'product_id' => '',
                'product' => '',
                'type' => 4,
                'search' => $search,
            ]);
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
