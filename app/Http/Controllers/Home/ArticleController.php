<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Models\ArticleModel;
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
    public function articleIndex()
    {
        $articles = ArticleModel::paginate(15);
        return view('home/article.article',[
            'articles' => $articles,
            'type' => 'article'
        ]);
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
            'type' => 'all'
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
        return view('home/article.articleCreate',[
            'products' => $products
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

        $str = EndaEditor::MarkDecode($request->input('content') ? $request->input('content') : '');
        $article->content = $str;
        preg_match ("<img.*src=[\"](.*?)[\"].*?>",$str,$match);
        $article->article_image = $match[1] ? $match[1] : '';
        $article->article_describe = $request->input('article_describe') ? $request->input('article_describe') : '';
        $article->article_time = $request->input('article_time') ? $request->input('article_time') : '';
        $articles = $article->save();
        if($articles == true){
            return redirect('/saas/article');
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
        return view('home/article.articleEdit',[
            'article' => $article,
            'products' => $products,
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
        $article['product_number'] = $product->number;
        if($article->update($request->all())){
            return redirect('/saas/article');
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
}
