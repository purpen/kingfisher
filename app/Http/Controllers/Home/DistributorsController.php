<?php
//经销商控制器
namespace App\Http\Controllers\Home;

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
                $categories = explode(',',$v['category_id']);
                $province = ChinaCityModel::where('oid',$v['province_id'])->select('name')->first();
                $category = CategoriesModel::whereIn('id',$categories)->select('type',1)->select('title')->get();
                $str = '';
                foreach ($category as $value) {
                    $str .= $value['title'] . ',';
                }
                if (count($province)>0) {
                    $distributor[$k]['province'] = $province->name;
                }else{
                    $distributor[$k]['province'] = '';
                }
                $distributor[$k]['category'] = substr($str,0,-1);
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
        if (count($distributors)>0) {
            $categories = explode(',',$distributors->category_id);
            $authorizations = explode(',', $distributors['authorization_id']);
            $province = ChinaCityModel::where('oid', $distributors->province_id)->select('name')->first();
            $category = CategoriesModel::whereIn('id', $categories)->where('type',1)->select('title')->get();
            $authorization = CategoriesModel::whereIn('id', $authorizations)->where('type',2)->select('title')->get();
            $str = '';
            foreach ($authorization as $value) {
                $str .= $value['title'] . ',';
            }
            $tit = '';
            foreach ($category as $val) {
                $tit .= $val['title'] . ',';
            }
            if (count($province)>0) {
                $distributors['province'] = $province->toArray()['name'];
            }else{
                $distributors['province'] = '';
            }

            $distributors['category'] =  substr($tit,0,-1);
            $distributors['authorization'] = substr($str, 0, -1);
        }

        $assets_front = AssetsModel::where(['target_id' => $id, 'type' =>17])->get();
        $assets_Inside = AssetsModel::where(['target_id' => $id, 'type' => 18])->get();
        $assets = AssetsModel::where(['target_id' => $id, 'type' => 19])->get();//营业执照
        $assets_portrait = AssetsModel::where(['target_id' => $id, 'type' => 20])->get();
        $assets_national_emblem = AssetsModel::where(['target_id' => $id, 'type' => 21])->get();

        $user = UserModel::where('id',$distributors->user_id)->select('phone','realname','account')->first();
        return view('home/distributors.details', [
            'distributors' => $distributors,
            'assets' => $assets,
            'user' => $user,
            'assets_front' => $assets_front,
            'assets_Inside' => $assets_Inside,
            'assets_portrait' => $assets_portrait,
            'assets_national_emblem' => $assets_national_emblem,
        ]);

    }

    public function search(Request $request)
    {
        $status = $request->input('status');
        $name = $request->input('name');
        $distributors = DistributorModel::where('name', 'like', '%' . $name . '%')->orWhere('store_name', 'like', '%' . $name . '%')->paginate($this->per_page);

        if (count($distributors)>0){
            foreach ($distributors as $k=>$v){
                $categories = explode(',',$v['category_id']);
                $province = ChinaCityModel::where('oid',$v['province_id'])->select('name')->first();
                $category = CategoriesModel::whereIn('id',$categories)->where('type',1)->select('title')->get();
                $str = '';
                foreach ($category as $value) {
                    $str .= $value['title'] . ',';
                }
                $distributor[$k]['province'] = $province->name;
                $distributor[$k]['category'] = substr($str,0,-1);
            }
            $distributors = $distributors->toArray();

            return view('home/distributors.distributors', [
                'distributors' => $distributors,
                'tab_menu' => $this->tab_menu,
                'status' => $status,
                'name' => $name,
            ]);
        } else {
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
        $distributors_id_array = $request->input('distributors')?$request->input('distributors'):'';
        if ($distributors_id_array !='') {
            foreach ($distributors_id_array as $id) {
                $distributorsModel = DistributorModel::find($id);
                $user =  DB::update("update users set verify_status=3,status=1 where id=$distributorsModel->user_id");

                if (!$distributorsModel->verify($id)) {
                    return ajax_json(1, '警告：审核失败');
                }
            }
        }else{
            return ajax_json(1,'您还没有勾选经销商！');
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
        $distributors_id_array = $request->input('distributors')?$request->input('distributors'):'';

        if ($distributors_id_array != '') {
            foreach ($distributors_id_array as $id) {
                $distributorsModel = new DistributorModel();
                if (!$distributorsModel->close($id)) {
                    return ajax_json('0', '关闭失败');
                }
            }
        }else{
            return ajax_json(1, '您还没有勾选经销商！');
        }
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