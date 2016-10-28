<?php

namespace App\Http\Controllers\Home;

use App\Models\ChinaCityModel;
use App\Models\CityModel;
use App\Models\ConsignorModel;
use App\Models\ProductsModel;
use App\Models\ProvinceModel;
use App\Models\StorageModel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreConsignorRequest;
use App\Http\Controllers\Controller;

class ConsignorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storage = new StorageModel();
        $storage_list = $storage->storageList(null);

        $china_city = ChinaCityModel::where('layer',1)->get();

        $consignors = ConsignorModel::get();
        return view('home.printSetup.consignor',['storage_list' => $storage_list,'consignors' => $consignors,'china_city' => $china_city]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = $request->all();
        if(!ConsignorModel::create($all)){
            return back()->withInput();
        }
        return redirect('/consignor');
    }

    

    //删除发货人
    public function ajaxDestroy(Request $request)
    {
        $id = (int)$request->input('id');
        if(ConsignorModel::destroy($id)){
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'error');
        }
    }

    /**
     * 获取详细信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxShow(Request $request)
    {
        $id = (int)$request->input('id');
        $model = ConsignorModel::find($id);
        if(!$model){
            return ajax_json(0,'error');
        }
        $model->storage_name = $model->storage->name;
        $model->province_name = ChinaCityModel::where('oid',$model->province_id)->first()->name;
        $model->city_name = ChinaCityModel::where('oid',$model->district_id)->first()->name;
        return ajax_json(1,'ok',$model);
    }

    /**
     * 更新详细信息
     * @param StoreConsignorRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit(Request $request)
    {
        $id = $request->input('consignor_id');
        $all = $request->all();
        if(!ConsignorModel::find($id)->update($all)){
            return back()->withInput();
        }
        return redirect('/consignor');
    }
}
