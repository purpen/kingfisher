<?php

namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\ArticleTransformer;
use App\Http\SaasTransformers\DescribeTransformer;
use App\Http\SaasTransformers\ImageTransformer;
use App\Http\SaasTransformers\VideoTransformer;
use App\Jobs\SendQiniuUpload;
use App\Models\ArticleModel;
use App\Models\MaterialLibrariesModel;
use App\Models\ProductsModel;
use App\Models\ProductUserRelation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use YuanChao\Editor\EndaEditor;
use Qiniu\Auth;
use App\Models\AssetsModel;
use App\Helper\Utils;

class MaterialLibrariesController extends BaseController
{
    /**
     * @api {get} /saasApi/product/describeLists 商品文字列表
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary lists
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} product_id 商品id
     * @apiParam {string} token token
     *
     * @apiSuccess {integer} type 附件类型: 1.图片； 2.视频；3.文字
     * @apiSuccess {string} product_number 商品号
     * @apiSuccess {string} describe 商品文字段内容
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 4,
                    "type": 3,
                    "product_number": "116110437384",
                    "describe": "第二条文字段我是"
                },
                {
                    "id": 3,
                    "type": 3,
                    "product_number": "116110437384",
                    "describe": "type是3的文字"
                }
            ],
            "meta": {
                "message": "Success.",
                "status_code": 200,
                "pagination": {
                    "total": 2,
                    "count": 2,
                    "per_page": 10,
                    "current_page": 1,
                    "total_pages": 1,
                    "links": []
                }
            }
        }

     */
    public function describeLists(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!$product){
            return $this->response->array(ApiHelper::error('not found', 200));
        }
        $product_number = $product->number;
        $describes = MaterialLibrariesModel::where(['product_number' => $product_number , 'type' => 3])
            ->orderBy('id', 'desc')
            ->paginate($per_page);
        return $this->response->paginator($describes, new DescribeTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /saasApi/product/describe 商品文字详情
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary describe
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} id 商品文字段id
     * @apiParam {string} token token
     *
     * @apiSuccess {integer} type 附件类型: 1.图片； 2.视频；3.文字
     * @apiSuccess {string} product_number 商品号
     * @apiSuccess {string} describe 商品文字段内容

     * @apiSuccessExample 成功响应:
        {
            "data":
            {
                "id": 4,
                "type": 3,
                "product_number": "116110437384",
                "describe": "第二条文字段我是"
            },
            "meta": {
                "message": "Success.",
                "status_code": 200,
            }
        }
     */
    public function describe(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = (int)$request->input('id');
        $describes = MaterialLibrariesModel::where(['id' => $id , 'type' => 3])->first();
        if(!$describes){
            return $this->response->array(ApiHelper::error('not found', 200));
        }
        $product_number = $describes->product_number;
        if(!empty($product_number)){
            $product = ProductsModel::where('number' , $product_number)->first();
            $product_id = $product->id;
            $productUserRelation = new ProductUserRelation();
            $describes->product = $productUserRelation->productInfo($user_id , $product_id);
        }else{
            $describes->product = '';

        }
        return $this->response->item($describes, new DescribeTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/product/imageLists 商品图片列表
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary imageLists
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} product_id 商品id
     * @apiParam {integer} image_type 图片类别: 1.场景； 2.细节；3.展示；
     * @apiParam {string} token token
     *
     * @apiSuccess {integer} type 附件类型: 1.图片； 2.视频；3.文字
     * @apiSuccess {string} product_number 商品号
     * @apiSuccess {string} image 商品图片
     * @apiSuccess {string} describe 商品图片描述
     * @apiSuccess {integer} image_type 图片类别: 1.场景； 2.细节；3.展示；
     *
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 2,
                    "type": 1,
                    "product_number": "116110437384",
                    "describe": "就是字段",
                    "image": "http://erp.me/images/default/erp_product.png"
                    "image_type": 1
                },
                {
                    "id": 1,
                    "type": 1,
                    "product_number": "116110437384",
                    "describe": "字段",
                    "image": "http://erp.me/images/default/erp_product.png"
                    "image_type": 1
                }
            ],
            "meta": {
                "message": "Success.",
                "status_code": 200,
                "pagination": {
                    "total": 2,
                    "count": 2,
                    "per_page": 10,
                    "current_page": 1,
                    "total_pages": 1,
                    "links": []
                }
            }
        }
     */
    public function imageLists(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $product = ProductsModel::where('id' , $product_id)->first();
        $image_type = $request->input('image_type');
        if(!$product){
            return $this->response->array(ApiHelper::success('not found', 200));
        }
        $product_number = $product->number;
        $query = MaterialLibrariesModel::query();
        if(!empty($image_type)){
            $describes = $query->where(['product_number' => $product_number , 'type' => 1 ,'image_type' => $image_type])
                ->orderBy('id', 'desc')
                ->paginate($per_page);;
        }else{
            $describes = $query->where(['product_number' => $product_number , 'type' => 1])
                ->orderBy('id', 'desc')
                ->paginate($per_page);
        }

        return $this->response->paginator($describes, new ImageTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/product/image 商品图片详情
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary image
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} id 商品图片id
     * @apiParam {string} token token
     *
     * @apiSuccess {integer} type 附件类型: 1.图片； 2.视频；3.文字
     * @apiSuccess {string} product_number 商品号
     * @apiSuccess {string} image 商品图片
     * @apiSuccess {string} describe 商品图片描述
     * @apiSuccess {integer} image_type 图片类别: 1.场景； 2.细节；3.展示；
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 1,
                "type": 1,
                "product_number": "116110437384",
                "describe": "字段",
                "image": "http://erp.me/images/default/erp_product.png"
                "image_type": 1
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function image(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = (int)$request->input('id');
        $image = MaterialLibrariesModel::where(['id' => $id , 'type' => 1])->first();
        if(!$image){
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        $product_number = $image->product_number;
        if(!empty($product_number)){
            $product = ProductsModel::where('number' , $product_number)->first();
            $product_id = $product->id;
            $productUserRelation = new ProductUserRelation();
            $image->product = $productUserRelation->productInfo($user_id , $product_id);
        }else{
            $image->product = '';

        }
        return $this->response->item($image, new ImageTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/product/videoLists 商品视频列表
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary videoLists
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} product_id 商品id
     * @apiParam {string} token token
     *
     * @apiSuccess {integer} type 附件类型: 1.图片； 2.视频；3.文字
     * @apiSuccess {string} product_number 商品号
     * @apiSuccess {string} video 商品视频
     * @apiSuccess {string} describe 商品视频描述
     *
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 2,
                    "type": 2,
                    "product_number": "116110437384",
                    "describe": "就是字段",
                    "video": "http://orrrmkk87.bkt.clouddn.com/saas_erp/20170706/595db176b0086"
                },
                {
                    "id": 1,
                    "type": 2,
                    "product_number": "116110437384",
                    "describe": "字段",
                    "video": "http://orrrmkk87.bkt.clouddn.com/saas_erp/20170706/595db176b0086"
                }
            ],
            "meta": {
                "message": "Success.",
                "status_code": 200,
                "pagination": {
                    "total": 2,
                    "count": 2,
                    "per_page": 10,
                    "current_page": 1,
                    "total_pages": 1,
                    "links": []
                }
            }
        }
     */
    public function videoLists(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!$product){
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        $product_number = $product->number;
        $videos = MaterialLibrariesModel::where(['product_number' => $product_number , 'type' => 2])
            ->orderBy('id', 'desc')
            ->paginate($per_page);
        return $this->response->paginator($videos, new VideoTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/product/video 商品视频详情
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary video
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} id 商品视频id
     * @apiParam {string} token token
     *
     * @apiSuccess {integer} type 附件类型: 1.图片； 2.视频；3.文字
     * @apiSuccess {string} product_number 商品号
     * @apiSuccess {string} video 商品视频
     * @apiSuccess {string} describe 商品视频描述
     *
     * @apiSuccessExample 成功响应:
    {
        "data": {
            "id": 1,
            "type": 1,
            "product_number": "116110437384",
            "describe": "字段",
            "video": "http://orrrmkk87.bkt.clouddn.com/saas_erp/20170706/595db176b0086"
        },
        "meta": {
            "message": "Success.",
            "status_code": 200
        }
    }
     */
    public function video(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = (int)$request->input('id');
        $videos = MaterialLibrariesModel::where(['id' => $id , 'type' => 2])->first();
        if(!$videos){
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        $product_number = $videos->product_number;
        if(!empty($product_number)){
            $product = ProductsModel::where('number' , $product_number)->first();
            $product_id = $product->id;
            $productUserRelation = new ProductUserRelation();
            $videos->product = $productUserRelation->productInfo($user_id , $product_id);
        }else{
            $videos->product = '';

        }
        return $this->response->item($videos, new VideoTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /saasApi/product/articleLists 商品文章列表
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary articleLists
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {integer} product_id 商品id
     * @apiParam {string} token token
     *
     * @apiSuccess {string} title 商品文章标题
     * @apiSuccess {string} author 商品文章作者
     * @apiSuccess {string} article_time 商品文章时间
     * @apiSuccess {string} article_type 商品文章类型1.创建； 2.抓取；3.分享
     * @apiSuccess {string} product_number 商品编号
     * @apiSuccess {string} content 商品文章内容
     * @apiSuccessExample 成功响应:
        {
            "data": [
                {
                    "id": 3,
                    "title": "第三个标题",
                    "author": "我是坐着",
                    "article_time": "2017-07-27",
                    "article_type": 1,
                    "product_number": "116110437384",
                    "content": "
                    内容要有图第三个

                    "
                },
            ],
            "meta": {
                "message": "Success.",
                "status_code": 200,
                "pagination": {
                    "total": 3,
                    "count": 3,
                    "per_page": 10,
                    "current_page": 1,
                    "total_pages": 1,
                    "links": []
                }
            }
        }
     *
     */
    public function articleLists(Request $request)
    {
        $product_id = (int)$request->input('product_id');
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page;
        $product = ProductsModel::where('id' , $product_id)->first();
        if(!$product){
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        $product_number = $product->number;
        $articles = ArticleModel::where(['product_number' => $product_number , 'status' => 1])
            ->orderBy('id', 'desc')
            ->paginate($per_page);
        foreach($articles as $article){
            $share = config('constant.h5_url').'/product/article_show/';
            $article_share = config('constant.h5_url').'/h5/article_show/';
            $article->share = $share;
            $article->article_share = $article_share;
        }
        return $this->response->paginator($articles, new ArticleTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /saasApi/product/article 商品文章详情
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary article
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} id 商品文章id
     *
     * @apiSuccess {string} title 商品文章标题
     * @apiSuccess {string} author 商品文章作者
     * @apiSuccess {string} article_time 商品文章时间
     * @apiSuccess {string} article_type 商品文章类型1.创建； 2.抓取；3.分享
     * @apiSuccess {string} product_number 商品编号
     * @apiSuccess {string} content 商品文章内容
     *
     * @apiSuccessExample 成功响应:
        {
            "data":
             {
                "id": 3,
                "title": "第三个标题",
                "author": "我是坐着",
                "article_time": "2017-07-27",
                "article_type": 1,
                "product_number": "116110437384",
                "content": "
                内容要有图第三个

                "
            },
            "meta": {
                "message": "Success.",
                "status_code": 200,
            }
        }
     */
    public function article(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = (int)$request->input('id');
        $article = ArticleModel::where(['id' => $id])->first();
        if(!$article){
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        $product_number = $article->product_number;
        if(!empty($product_number)){
            $product = ProductsModel::where('number' , $product_number)->first();
            $product_id = $product->id;
            $productUserRelation = new ProductUserRelation();
            $article->product = $productUserRelation->productInfo($user_id , $product_id);
        }else{
            $article->product = '';
        }
        $content = $article->content;
        $str = EndaEditor::MarkDecode($content);
        $article->content = $str;
        $share = config('constant.h5_url').'/product/article_show/';
        $article_share = config('constant.h5_url').'/h5/article_show/';
        $article->share = $share;
        $article->article_share = $article_share;
        return $this->response->item($article, new ArticleTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {post} /saasApi/product/articleStore 商品文章抓取添加
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary articleStore
     * @apiGroup MaterialLibrary
     *
     *
     */
    public function articleStore(Request $request)
    {
        $all = file_get_contents('php://input');
        $all_json = json_decode($all, true);
        $article['title'] = $all_json['title'];
        $title = ArticleModel::where('title' , $article['title'])->first();
        if(!empty($title)){
            return $this->response->array(ApiHelper::error('已存在该文章', 200));
        }
        $article['article_time'] = $all_json['date'];
        $article['author'] = $all_json['author'];
        $article['article_type'] = 2;
        $article['site_from'] = $all_json['site_from'];
        $article['site_type'] = $all_json['site_type'];

        $contents = $all_json['content'];
        foreach ($contents as $content){
            if($content['type'] == 1){
                $value1 = $content['value'];
                $article['article_describe'] = $value1;
            }else{
                $value1='';
            }
            if($content['type'] == 2){
                $url = $content['value'];
                $mater = new MaterialLibrariesModel();
                $qiNiu = $mater->grabUpload($url);
                $value2 = "\n\n".'![]('.$qiNiu.'-p800'.')'."\n\n";
            }else{
                $value2='';
            }
            $contentValues[] =  $value1.''.$value2;
            $contentVs = implode('@!@' , $contentValues);
            $contentValue = str_replace('@!@' , '' , $contentVs);
        }

        $article['content'] = $contentValue;
        $article['product_number'] = '';
        $articles = ArticleModel::create($article);
        if(!$articles){
            return $this->response->array(ApiHelper::error('保存失败', 401));
        }
        return $this->response->array(ApiHelper::success('保存成功', 200));
    }

    /**
     * 下载文件
     */
    public function downloadZip(Request $request)
    {
        $userId = $this->auth_user_id;
        $id = (int)$request->input('id');
        if(!$id){
            return $this->response->array(ApiHelper::error('缺少请求参数！', 401));
        }

        // 优先从附件表查找
        $asset = AssetsModel::where(array('target_id'=>$id, 'type'=>11))->first();
        if ($asset) {
            $assetId = $asset->id;
            $downUrl = config('qiniu.material_url').$asset->path.'?attname='.$id.'.zip';
            return $this->response->array(ApiHelper::success('Success.', 200, array('asset_id'=> $assetId, 'url' => $downUrl)));            
        }
        // 素材压缩保存
        $result = Utils::genArticleZip($id, array('user_id'=> $this->auth_user_id));

        if($result['success']){
            return $this->response->array(ApiHelper::success('Success.', 200, $result['data']));
        }else{
            return $this->response->array(ApiHelper::error($result['message'], 401));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
