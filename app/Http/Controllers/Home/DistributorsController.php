<?php
//经销商控制器
namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Http\Controllers\Controller;
use App\Models\AssetsModel;
use App\Models\CategoriesModel;
use App\Models\ChinaCityModel;
use App\Models\DistributorModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistributorsController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->input('status')?$request->input('status') : '';
        $this->tab_menu = 'verified';
        if(!in_array($status,[1,2,3,4])){

            $distributor = DistributorModel::orderBy('id', 'desc')->paginate($this->per_page);
        }else{
            $distributor = DistributorModel::where('status', $status)->orderBy('id', 'desc')->paginate($this->per_page);
        }
        if (count($distributor)>0){
            foreach ($distributor as $k=>$v){
//                $categories = explode(',',$v['category_id']);
                $province = ChinaCityModel::where('oid',$v['province_id'])->select('name')->first();
//                $category = CategoriesModel::whereIn('id',$categories)->select('type',1)->select('title')->get();

//                $str = '';
//                if (count($category)>0) {
//                    foreach ($category as $value) {
//                        $str .= $value['title'] . ',';
//                    }
//                    $distributor[$k]['category'] = substr($str,0,-1);
//                }else{
//                    $distributor[$k]['category'] = '';
//                }
                if ($province) {
                    $distributor[$k]['province'] = $province->name;
                }else{
                    $distributor[$k]['province'] = '';
                }

            }
            $distributor = $distributor->toArray();
        }

        return view('home/distributors.distributors', [
            'status' => $status,
            'tab_menu' => $this->tab_menu,
            'distributors'=> $distributor

        ]);
    }

    /**
     * 详情
     */
    public function details(Request $request)
    {
        $id = $request->input('id');
        $distributors = DistributorModel::where('id' , $id)->first();

        $categorys = CategoriesModel::where('type','=',1)->where('status',1)->get();//所有商品分类列表
        $authorization = CategoriesModel::where('type','=',2)->where('status',1)->get();//获取授权条件

        if ($distributors->category_id && $distributors->authorization_id){
            $categorie = explode(',',$distributors->category_id);
            $authoriza = explode(',', $distributors->authorization_id);
        }else{
            $categorie =[];
            $authoriza =[];
        }
        if (count($distributors)>0) {
            $province = ChinaCityModel::where('oid', $distributors->province_id)->select('name')->first();
            $city = ChinaCityModel::where('oid', $distributors->city_id)->select('name')->first();
            $enter_province = ChinaCityModel::where('oid', $distributors->enter_province)->select('name')->first();
            $enter_city = ChinaCityModel::where('oid', $distributors->enter_city)->select('name')->first();
//            $category = CategoriesModel::whereIn('id', $categories)->where('type',1)->select('title')->get();
//            $authorization = CategoriesModel::whereIn('id', $authorizations)->where('type',2)->select('title')->get();
//            $str = '';
//            foreach ($authorization as $value) {
//                $str .= $value['title'] . ',';
//            }
//            $tit = '';
//            foreach ($category as $val) {
//                $tit .= $val['title'] . ',';
//            }
            if ($province && $city) {
                $distributors['address'] = $province->toArray()['name'].','.$city->toArray()['name'].$distributors->store_address;
            }else{
                $distributors['address'] = '';
            }
            if ($enter_province && $enter_city) {
                $distributors['enter_address'] = $enter_province->toArray()['name'].','.$enter_city->toArray()['name'].$distributors->enter_Address;
            }else{
                $distributors['enter_address'] = '';
            }
//            $distributors['category'] =  substr($tit,0,-1);
//            $distributors['authorization'] = substr($str, 0, -1);
        }
        $assets_front = AssetsModel::find($distributors->front_id);
        $assets_Inside = AssetsModel::find($distributors->Inside_id);
        $assets_contract = AssetsModel::find($distributors->contract_id);
        $assets_portrait = AssetsModel::find($distributors->portrait_id);
        $assets_national_emblem = AssetsModel::find($distributors->national_emblem_id);
        $user = UserModel::where('id',$distributors->user_id)->select('phone','realname','account')->first();
        $random = uniqid();  //获取唯一字符串
        //获取七牛上传token
        $token = QiniuApi::upToken();
        $user_id = Auth::user()->id;
        return view('home/distributors.details', [
            'distributors' => $distributors,
            'categorys' => $categorys,
            'categorie' => $categorie,
            'authorization' => $authorization,
            'authoriza' => $authoriza,
            'user' => $user,
            'token' => $token,
            'user_id' => $user_id,
            'random' => $random,
            'assets_front' => $assets_front,
            'assets_Inside' => $assets_Inside,
            'assets_contract' => $assets_contract,
            'assets_portrait' => $assets_portrait,
            'assets_national_emblem' => $assets_national_emblem,
        ]);

    }

    public function search(Request $request)
    {
        $status = $request->input('status','');
        $name = $request->input('name');
        $distributors = DistributorModel::where('name', 'like', '%' . $name . '%')->orWhere('store_name', 'like', '%' . $name . '%')->paginate($this->per_page);

        if (count($distributors)>0) {
            foreach ($distributors as $k => $v) {
//                $categories = explode(',', $v['category_id']);
                $province = ChinaCityModel::where('oid', $v['province_id'])->select('name')->first();
//                $category = CategoriesModel::whereIn('id', $categories)->where('type', 1)->select('title')->get();
                if ($province) {
                    $distributors[$k]['province'] = $province->name;
                } else {
                    $distributors[$k]['province'] = '';
                }
            }
            $distributors = $distributors->toArray();

            return view('home/distributors.distributors', [
                'distributors' => $distributors,
                'tab_menu' => $this->tab_menu,
                'status' => $status,
                'name' => $name,
            ]);
        }else {
            return view('home/distributors.distributors');
        }
    }




    /**
     *审核供应商信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxVerify(Request $request)
    {
        $id = $request->input('id');
        $category_id = $request->input('diyu')?$request->input('diyu'):'';
        $authorization_id = $request->input('Jszzdm')?$request->input('Jszzdm'):'';
        $mode = $request->input('mode')?$request->input('mode'):'';
        $contract_id = $request->input('contract_id')?$request->input('contract_id'):0;
        $distributorsModel = DistributorModel::find($id);
        if($distributorsModel !='') {

            $users = UserModel::where('id', '=', $distributorsModel->user_id)->where('verify_status', '!=', 3)->where('status', '!=', 1)->first();
            if ($users) {
                $user = DB::update("update users set verify_status=3,status=1 where id=$distributorsModel->user_id");
                if (!$user) {
                    return ajax_json(1, '警告：用户信息保存失败');
                }
            }
            if ($category_id != '' && $authorization_id != '') {
                $distributors = DB::update("update distributor set category_id='$category_id',authorization_id='$authorization_id',mode='$mode',contract_id='$contract_id' where id=$id");
                if (!$distributors) {
                    return ajax_json(1, '警告：请完善必填项');
                }
            }
            if (!$distributorsModel->verify($id)) {
                return ajax_json(1, '警告：审核失败');
            }
        }else{
            return ajax_json(1, '没有找到该供应商信息');
        }
        return ajax_json(0, '操作成功！');
    }


    /**
     * 经销商关闭使用
     *
     * @param Request $request
     * @return string
     */
    public function ajaxClose(Request $request)
    {
        $id = $request->input('id');
        $model = DistributorModel::find($id);
        if(!$model){
            return ajax_json(1,'没有找到该供应商信息');
        }

//        $distributors_id_array = $request->input('distributors')?$request->input('distributors'):'';

//        if ($distributors_id_array != '') {
//            foreach ($distributors_id_array as $id) {
                $distributorsModel = new DistributorModel();
                if (!$distributorsModel->close($id)) {
                    return ajax_json(1, '关闭失败');
                }
//            }
//        }else{
//            return ajax_json(1, '您还没有勾选经销商！');
//        }
        return ajax_json(0, '操作成功');
    }


    public function ajaxDestroy(Request $request)
    {
        $id = (int)$request->input('id');
        if (empty($id)) {
            return ajax_json(0, '参数错误');
        }
        $order_model = DistributorModel::find($id);
        if(!$order_model){
            return ajax_json(0,'该经销商不存在');
        }

        if($order_model->status == 2){
            return ajax_json(0,'已完成的不能删除!');
        }

        if(Auth::user()->hasRole(['admin']) && $order_model->status != 2){//已完成的不能删除
            $order_model->forceDelete();
            }

            return ajax_json(1,'ok');
        }
}