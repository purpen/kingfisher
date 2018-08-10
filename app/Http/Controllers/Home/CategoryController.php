<?php

namespace App\Http\Controllers\Home;

use App\Models\ProductsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\CategoriesModel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = new CategoriesModel();
        $product_list = $category::get();
        
        return view('home/category.category',['product_list' => $product_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new CategoriesModel();
        $title =  $request->input('title');

        if(CategoriesModel::where('title',$title)->count() > 0){//已有的分类不能重复添加
//          session()->flash('msg','该分类已存在');//信息闪存bie
            return ajax_json(1,'该分类已存在！');
        }

        $category->title = $title;
        $category->pid = (int)$request->input('pid', 0);
        $category->order = $request->input('order',0);
        $category->type = (int)$request->input('type','1');
        $category->status = (int)$request->input('status',1);;
        if ($category->save()) {
//            return back()->withInput();
            return ajax_json(0,'添加成功！');
        }

    }



    /**
     * 获取分类信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxEdit(Request $request)
    {
        $id = (int)$request->input('id');

//        if(ProductsModel::where('category_id',$id)->count() > 0){
//            return ajax_json(0,'分类已使用，不能修改');
//        }

        $category = CategoriesModel::find($id);
        if(!$category){
            return ajax_json(0,'error');
        }else{
            return  ajax_json(1,'ok',$category);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = (int)$request->input('id');

        $model = CategoriesModel::find($id);
        if(!$model){
            return view('errors.503');
        }

        $model->title = $request->input('title');
        $model->order = $request->input('order');
        $model->type = $request->input('type');
        $model->status = $request->input('status');
        if(!$model->save()){
            return view('errors.503');
        }
        return back()->withInput();
    }

    /**
     * 删除分类
     *
     * @param  int  $id
     * @return
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if(CategoriesModel::destroy($id)){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
    }

}
