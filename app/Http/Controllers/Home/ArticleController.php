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
use Qiniu\Storage\UploadManager;
use YuanChao\Editor\EndaEditor;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articleIndex(Request $request)
    {
        $type = $request->input('type') ? $request->input('type') : 4;
        $product_id = $request->input('id') ? $request->input('id') : '';
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!empty($product)){
            $product_number = $product->number;
        }else{
            $product_number = '';
        }
        if(!empty($product_number)){
            $materialLibraries = MaterialLibrariesModel::where('type' , $type)->where('status' , 1)->where('product_number' , $product_number)->orderBy('created_at' , 'desc')->paginate(15);
        }else{
            $materialLibraries = MaterialLibrariesModel::where('type' , $type)->where('status' , 1)->orderBy('created_at' , 'desc')->paginate(15);
        }

        if($type == 1){
            return view('home/materialLibraries.image',[
                'materialLibraries' => $materialLibraries,
                'type' => 1,
                'search' => '',
                'product_id' => $product_id,
                'status' => 1

            ]);
        }
        if($type == 2){
            return view('home/materialLibraries.video',[
                'materialLibraries' => $materialLibraries,
                'type' => 2,
                'search' => '',
                'product_id' => $product_id,
                'status' => 1
            ]);
        }
        if($type == 3){
            return view('home/materialLibraries.describe',[
                'materialLibraries' => $materialLibraries,
                'type' => 3,
                'search' => '',
                'product_id' => $product_id,
                'status' => 1


            ]);
        }
        if($type == 4){
            if(!empty($product_number)){
                $articles = ArticleModel::where('product_number' , $product_number)->where('status' , 1)->orderBy('created_at' , 'desc')->paginate(15);
            }else{
                $articles = ArticleModel::where('status' , 1)->orderBy('created_at' , 'desc')->paginate(15);
            }
            return view('home/article.article',[
                'articles' => $articles,
                'search' => '',
                'product_id' => $product_id,
                'product' => $product,
                'type' => 4,
                'status' => 1
            ]);
        }
    }

    public function articleNoStatusIndex(Request $request)
    {
        $type = $request->input('type') ? $request->input('type') : 4;
        $product_id = $request->input('id') ? $request->input('id') : '';
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!empty($product)){
            $product_number = $product->number;
        }else{
            $product_number = '';
        }

        if(!empty($product_number)){
            $materialLibraries = MaterialLibrariesModel::where('type' , $type)->where('status' , 0)->where('product_number' , $product_number)->orderBy('created_at' , 'desc')->paginate(15);
        }else{
            $materialLibraries = MaterialLibrariesModel::where('type' , $type)->where('status' , 0)->orderBy('created_at' , 'desc')->paginate(15);
        }

        if($type == 1){
            return view('home/materialLibraries.image',[
                'materialLibraries' => $materialLibraries,
                'type' => 1,
                'search' => '',
                'product_id' => $product_id,
                'status' => 0

            ]);
        }
        if($type == 2){
            return view('home/materialLibraries.video',[
                'materialLibraries' => $materialLibraries,
                'type' => 2,
                'search' => '',
                'product_id' => $product_id,
                'status' => 0
            ]);
        }
        if($type == 3){
            return view('home/materialLibraries.describe',[
                'materialLibraries' => $materialLibraries,
                'type' => 3,
                'search' => '',
                'product_id' => $product_id,
                'status' => 0


            ]);
        }
        if($type == 4){
            if(!empty($product_number)){
                $articles = ArticleModel::where('product_number' , $product_number)->where('status' , 0)->orderBy('created_at' , 'desc')->paginate(15);
            }else{
                $articles = ArticleModel::where('status' , 0)->orderBy('created_at' , 'desc')->paginate(15);
            }
            return view('home/article.article',[
                'articles' => $articles,
                'search' => '',
                'product_id' => $product_id,
                'product' => $product,
                'type' => 4,
                'status' => 0
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articles()
    {
        $articles = ArticleModel::paginate(15);

        return view('home/article.article',[
            'articles' => $articles,
            'product_id' => '',
            'product' => '',
            'type' => 4,
            'search' => '',

        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articleCreate()
    {
        $products = ProductsModel::where('saas_type' , 1)->get();
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        $random = uniqid();
        $material_upload_url = config('qiniu.material_upload_url');
        return view('home/article.articleCreate',[
            'token' => $token,
            'products' => $products,
            'random' => $random,
            'material_upload_url' => $material_upload_url,
            'search' => '',
            'type' => 4,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function articleStore(Request $request)
    {
        $product_id = $request->input('product_id');
        $article = new ArticleModel();
        if(!empty($product_id)){
            $product = ProductsModel::where('id' , $product_id)->first();
            $article->product_number = $product->number;
        }else{
            $article->product_number = '';
        }
        $article->article_type = $request->input('article_type') ? $request->input('article_type') : '';
        $article->title = $request->input('title') ? $request->input('title') : '';
        $article->site_from = $request->input('site_from') ? $request->input('site_from') : '';
        $article->author = $request->input('author') ? $request->input('author') : '';
        $article->content = $request->input('content') ? $request->input('content') : '';
        $article->content = $request->input('cover_id') ? $request->input('cover_id') : '';
        $article->article_describe = $request->input('article_describe') ? $request->input('article_describe') : '';
        $article->article_time = $request->input('article_time') ? $request->input('article_time') : '';
        if($article->save()){
            $materialLibraries = MaterialLibrariesModel::where('random',$request->input('random'))->get();
            foreach ($materialLibraries as $materialLibrary){
                $materialLibrary->target_id = $article->id;
                $materialLibrary->type = 4;
                $materialLibrary->save();
            }
            return redirect('/saas/article');
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
    public function articleEdit($id)
    {
        $products = ProductsModel::where('saas_type' , 1)->get();
        $article = ArticleModel::where('id' , $id)->first();
        //获取七牛上传token
        $token = QiniuApi::upMaterialToken();
        $random = uniqid();
        $material_upload_url = config('qiniu.material_upload_url');
        $materialLibraries = MaterialLibrariesModel::where(['target_id' => $id , 'type' => 4])->get();
        return view('home/article.articleEdit',[
            'article' => $article,
            'token' => $token,
            'products' => $products,
            'random' => $random,
            'material_upload_url' => $material_upload_url,
            'materialLibraries' => $materialLibraries,
            'search' => '',
            'type' => 4,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function articleUpdate(Request $request)
    {
        $product = ProductsModel::where('id' , $request->input('product_id'))->first();
        $id = (int)$request->input('article_id');
        $article = ArticleModel::find($id);
        if(!empty($product)){
            $article['product_number'] = $product->number;
        }else{
            $article['product_number'] = '';
        }
        if($article->update($request->all())){
            $materialLibraries = MaterialLibrariesModel::where('random',$request->input('random'))->get();
            foreach ($materialLibraries as $materialLibrary){
                $materialLibrary->target_id = $article->id;
                $materialLibrary->type = 4;
                $materialLibrary->save();
            }
            return redirect('/saas/article');
        }else{
            return "更新失败";
        }
    }

    //删除
    public function delete($id)
    {
        if(ArticleModel::destroy($id)){
            return back()->withInput();
        }
    }

    /**
    *文章图片上传到七牛服务器
     */

    public function imageUpload(Request $request)
    {
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('qiniu.material_bucket_name');

        $token = $auth->uploadToken($bucket);
        //获取文件
        $file = $request->file('image');
        //获取文件路径
        $filePath = $file->getRealPath();
        // 上传到七牛后保存的文件名
        $date = time();
        $key = 'article/'.$date.'/'.uniqid();
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        $data = array(
            'status'=> 0,
            'message'=> 'ok',
            'url'=> config('qiniu.material_url').$key
        );
        return $data;
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

    //全部文章
    public function articleAll()
    {
        $articles = ArticleModel::paginate(15);

        return view('home/article.articleAll',[
            'articles' => $articles,
            'product_id' => '',
            'product' => '',
            'type' => 4,
            'search' => '',

        ]);
    }

    /*
* 状态
*/
    public function status(Request $request, $id)
    {
        $ok = ArticleModel::okStatus($id, 1);
        return back()->withInput();
    }

    public function unStatus(Request $request, $id)
    {
        $ok = ArticleModel::okStatus($id, 0);
        return back()->withInput();
    }
}
