<?php
//经销商控制器
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\CategoriesModel;
use App\Models\ChinaCityModel;
use App\Models\DistributorModel;
use Illuminate\Http\Request;

class DistributorsController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->input('status');
        $this->tab_menu = 'verified';
        if(!in_array($status,[1,2,3,4])){

            $distributor = DistributorModel::orderBy('id', 'desc')->paginate($this->per_page);
        }else{
            $distributor = DistributorModel::where('status', $status)->orderBy('id', 'desc')->paginate($this->per_page);
        }
        $a = '';
        $b = '';
        foreach ($distributor as $v){
            $a = $v['province_id'];
            $b = $v['category_id'];
        }
        $province = ChinaCityModel::where('id',$a)->select('name')->first();
        $category = CategoriesModel::where('id',$b)->select('title')->first();
        $distributor = $distributor->toArray();

        $distributor['province'] = $province->toArray();
        $distributor['category'] = $category->toArray();
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
        $authorizations = explode(',',$distributors['authorization_id']);
        $province = ChinaCityModel::where('id',$distributors->province_id)->select('name')->first();
        $category = CategoriesModel::where('id',$distributors->category_id)->select('title')->first();
        $authorization = CategoriesModel::whereIn('id',$authorizations)->select('title')->get();
        $str = '';
        foreach ($authorization as $value){
            $str .= $value['title'].',';
        }
        $str = substr($str,0,-1);
        $distributors['province'] = $province->toArray()['name'];
        $distributors['category'] = $category->toArray()['title'];
        $distributors['authorization'] = $str;
        return view('home/distributors.details', [
            'distributors' => $distributors,
        ]);

    }

    public function search(Request $request)
    {
        $status = $request->input('status');
        $name = $request->input('name');
        $distributor = DistributorModel::where('name', 'like', '%' . $name . '%')->paginate($this->per_page);

        foreach ($distributor as $v){
            $a = $v['province_id'];
            $b = $v['category_id'];
        }
        $province = ChinaCityModel::where('id',$a)->select('name')->first();
        $category = CategoriesModel::where('id',$b)->select('title')->first();
        $distributors = $distributor->toArray();

        $distributors['province'] = $province->toArray();
        $distributors['category'] = $category->toArray();
        if ($distributors) {
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
        var_dump($distributors_id_array);die;
//        $msg = $request->input("msg")?$request->input("msg"):'';
        if ($supplier_id_array !='') {
            foreach ($supplier_id_array as $id) {
                $supplierModel = SupplierModel::find($id);

//            if ($supplierModel->status != 1) {
//                return ajax_json(0, '警告：该供应商无法审核！');
//            }
//                上传电子版合同
                if (empty($supplierModel->electronic_contract_report_id)) {
                    return ajax_json(1, '警告：未上传电子版合同，无法通过审核！');
                }


                if (empty($supplierModel->cover_id)) {
                    return ajax_json(1, '警告：未上传合作协议扫描件，无法通过审核！');
                }

                if (!$supplierModel->verify($id)) {
                    return ajax_json(1, '警告：审核失败');
                }


            }
        }else{
            return ajax_json(1,'您还没有勾选供应商！');
        }

        $in = str_repeat('?,', count($supplier_id_array) - 1) . '?';
        $bind_value = array_merge([$msg], $supplier_id_array);

        $arr = DB::update("update suppliers set msg=? where id IN ($in)", $bind_value);
        return ajax_json(0, '操作成功！');
    }
}