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
//        $value2 = '![]'.'('.'http://orrrmkk87.bkt.clouddn.com/saas_erp/20170705/595ca5558e889'.')';
//        dd($value2);
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
        dd($request->all());
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
//        $article->content = $request->input('content') ? $request->input('content') : '';
        $article->content = '[{ "type" : 1, "value" : " 今年下半年大量的全面屏手机将和大家见面。近日华为的全面屏旗舰新机也有了消息。" }, { "type" : 1, "value" : "视频大小约6.3MB" }, { "type" : 1, "value" : "时间来到了2017年下半年，接下来又回有一大波新的旗舰机型面世。" }, { "type" : 1, "value" : "据多方消息显示，华为 Mate 10将采用全新的麒麟970处理器。麒麟970将会采用10nm工艺制造，同时GPU会有所增强，补足目前GPU性能不给力的缺点。" }, { "type" : 1, "value" : "在2017年下半年全面屏爆发之际，华为也不会闲着。" }, { "type" : 2, "value" : "https://mmbiz.qpic.cn/mmbiz_png/5cldnoUxUib7BtQu8WpHBrsH7jtNcKPGNxKQYl6Rj0P2EzAEvGYtXGVancBZRiccrI1FWOdpd68mrZwHFITWUgYQ/640?wx_fmt=png&wxfrom=5&wx_lazy=1" }, { "type" : 1, "value" : "日前网友放出了一张全面屏新机的照片，从图片中可以看到该机上下边很窄，左右无边框，屏占比超高，并且下巴清晰可见华为荣耀的Logo，可以确认为荣耀旗下产品。" }, { "type" : 2, "value" : "https://mmbiz.qpic.cn/mmbiz_jpg/5cldnoUxUib7BtQu8WpHBrsH7jtNcKPGN6RTlv4YHH5YSrxZ7icv74fCYPFAMBzEnn8qHelMZCxibXKtNQt04MgAA/640?wx_fmt=jpeg&wxfrom=5&wx_lazy=1" }, { "type" : 1, "value" : "从外形上看，" }, { "type" : 1, "value" : "根据此前传出的消息，荣耀Note 9将会配备6.6英寸2K显示屏，6GB RAM+64GB ROM存储组合，电池容量将会升级到5000mAh。至于处理器方面，据媒体报道华为Mate 10将首发麒麟970处理器，所以荣耀Note 9搭载的应该是麒麟960。" }, { "type" : 1, "value" : "请到“资讯100秒”微信公众号文章中投票" }, { "type" : 1, "value" : "本文由“135编辑器”提供技术支持" }, { "type" : 1, "value" : "近期文章精选：" }, { "type" : 1, "value" : "三星Note8终于曝光，正面阻击iPhone 8" }, { "type" : 1, "value" : "小米手机二季度销量超过2300万，明年有个小目标：一亿台" }, { "type" : 1, "value" : "魅族 PRO 7 双屏旗舰360度清晰曝光（视频）" }, { "type" : 1, "value" : "小米两款全面屏旗舰新机即将发布：抢在魅族 PRO 7前面" }, { "type" : 1, "value" : "新 iPhone就这样了，iPhone 8真机模型体验（视频）" }, { "type" : 2, "value" : "https://mmbiz.qpic.cn/mmbiz_png/5cldnoUxUib7BtQu8WpHBrsH7jtNcKPGNO1m4BTCmYl8DXiaOhqp7jWFzRq4RhMJKLEQQWKshicCp2gDiaOsl5XYlw/640?wx_fmt=png&wxfrom=5&wx_lazy=1" }, { "type" : 2, "value" : "https://mmbiz.qpic.cn/mmbiz_png/TWTeiaAEGYyicYKuU8sibNJR14rJg4jjz5c2IiaMiaFQ0YUibz6PE5E48ROD5Qatbz3w37PIoecevmfwRVx7O6GhlBEw/640?wx_fmt=png&wxfrom=5&wx_lazy=1" }]';
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
        $id = (int)$request->input('article_id');
        $article = ArticleModel::find($id);
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


    public function imageUpload(Request $request)
    {
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('qiniu.material_bucket_name');

        $token = $auth->uploadToken($bucket);
        $file = $request->file('image');
        $filePath = $file->getRealPath();
        // 上传到七牛后保存的文件名
        $date = time();
        $key = 'saas_erp/'.$date.'.'.uniqid();
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        $err = $uploadMgr->putFile($token, $key, $filePath);
        Log::info($err);
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
