<?php

namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\ArticleTransformer;
use App\Http\SaasTransformers\DescribeTransformer;
use App\Http\SaasTransformers\ImageTransformer;
use App\Http\SaasTransformers\VideoTransformer;
use App\Models\ArticleModel;
use App\Models\MaterialLibrariesModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
        $id = (int)$request->input('id');
        $describes = MaterialLibrariesModel::where(['id' => $id , 'type' => 3])->first();
        if(!$describes){
            return $this->response->array(ApiHelper::error('not found', 200));
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
        $id = (int)$request->input('id');
        $describes = MaterialLibrariesModel::where(['id' => $id , 'type' => 1])->first();
        if(!$describes){
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        return $this->response->item($describes, new ImageTransformer())->setMeta(ApiHelper::meta());
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
        $id = (int)$request->input('id');
        $videos = MaterialLibrariesModel::where(['id' => $id , 'type' => 2])->first();
        if(!$videos){
            return $this->response->array(ApiHelper::error('not found', 404));
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
        $article = ArticleModel::where(['product_number' => $product_number])
            ->orderBy('id', 'desc')
            ->paginate($per_page);
        return $this->response->paginator($article, new ArticleTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /saasApi/product/article 商品文章详情
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary article
     * @apiGroup MaterialLibrary
     *
     * @apiParam {integer} id 商品文章id
     * @apiParam {string} token token
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
        $id = (int)$request->input('id');
        $article = ArticleModel::where(['id' => $id])->first();
        if(!$article){
            return $this->response->array(ApiHelper::error('not found', 404));
        }
        return $this->response->item($article, new ArticleTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {post} /saasApi/product/articleStore 商品文章抓去添加
     * @apiVersion 1.0.0
     * @apiName MaterialLibrary articleStore
     * @apiGroup MaterialLibrary
     *
     *
     */
    public function articleStore(Request $request)
    {
//        $article = new ArticleModel();
//        $article->title = $request['title'];
//        $article->article_time = $request['date'];
//        $article->author = $request['author'];
//        $article->article_type = 2;
//        $content = $request['content'];
//        Log::info($request->getContent());
        Log::info(json_encode($request->all()));
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
