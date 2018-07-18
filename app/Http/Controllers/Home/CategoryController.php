<?php

namespace App\Http\Controllers\Home;

use App\Models\ChinaCityModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\CategoriesModel;
use Illuminate\Support\Facades\DB;

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

        $province = new ChinaCityModel();
        $provinces = $province->fetchCity();//所有省
        return view('home/category.category',['product_list' => $product_list,'provinces' => $provinces]);
    }

    //获取城市

    public function getCitys(Request $request)
    {
        $id = $request->input('id');
        $oids = ChinaCityModel::where('id',$id)->select('oid')->first();
        $oid = $oids->toArray();

        $citys=DB::table('china_cities')->where('pid','=',$oid)->select('name','oid')->get();
        $city = objectToArray($citys);
        if(!$city){
            return ajax_json(0,'无下级地区');
        }
        return ajax_json(1,'下级地区列表',$city);

    }

    //获取区/县
    public function getAreas(Request $request)
    {
        $oid = $request->input('oid');
        $areas=DB::table('china_cities')->whereIn('pid',$oid)->select('name','oid')->get();
        $area = objectToArray($areas);
        if(!$area){
            return ajax_json(0,'无下级地区');
        }
        return ajax_json(1,'下级地区列表',$area);
    }

    public function getAll(Request $request)
    {
        $oid = $request->input('oid');
        $area = DB::table('china_cities')->whereIn('oid',$oid)->select('name','pid')->get();//区
        $areas = objectToArray($area);
        $citys=[];
        $provinces=[];
        foreach ($areas as $v){
            $city = DB::table('china_cities')->where('oid','=',$v['pid'])->select('name','pid')->first();//市
            $citys = objectToArray($city);
                $province = DB::table('china_cities')->where('oid','=',$citys['pid'])->select('name')->first();//省
                $provinces = objectToArray($province);
        }
//        $arr = array();
//        $arr = array_merge($arr,$areas);
//        $arr = array_merge($arr,$citys);
//        $arr = array_merge($arr,$provinces);
//        echo json_encode($arr);die;

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
//        $category->type = (int)$request->input('type','1');
        $category->type = (int)$request->input('type');
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
