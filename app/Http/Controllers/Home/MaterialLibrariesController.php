<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Models\MaterialLibrariesModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Auth;

class MaterialLibrariesController extends Controller
{
    /**
     * 生成上传图片upToken
     * @return string
     */
    public function upToken()
    {
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('qiniu.material_bucket_name');

        // 上传文件到七牛后， 七牛将callbackBody设置的信息回调给业务服务器
        $policy = array(
            'callbackUrl' => config('qiniu.material_call_back_url'),
            'callbackFetchKey' => 1,
            'callbackBody' => 'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&product_number=$(x:product_number)',
        );
        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);

        return $upToken;
    }

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
        $imageData['product_number'] = $post['product_number'];
        $key = uniqid();
        $imageData['path'] = config('qiniu.domain') . '/' .date("Ymd") . '/' . $key;

        if($materialLibraries = MaterialLibrariesModel::create($imageData)){
            $id = $materialLibraries->id;
            $callBackDate = [
                'key' => $materialLibraries->path,
                'payload' => [
                    'success' => 1,
                    'name' => config('qiniu.material_url').$materialLibraries->path,
                    'small' => config('qiniu.material_url').$materialLibraries->path.config('qiniu.material_url'),
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
    public function index()
    {
        return view('home/materialLibraries.materialLibrary',[

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取七牛上传token
        $token = QiniuApi::upToken();

        return view('home/materialLibraries.create',[
            'token' => $token
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_number = $request->input('product_number');
        $product = ProductsModel::where('number' , $product_number)->first();

        if($product){
            $materialLibraries = MaterialLibrariesModel::get();
            foreach ($materialLibraries as $materialLibrary){
                $materialLibrary->product_number = $product_number;
                $materialLibrary->type = 1;
                $materialLibrary->save();
            }
            return redirect('/image');
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
