<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Common\AssetController;
use App\Models\AssetsModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = SupplierModel::where('status',2)->orderBy('id','desc')->paginate(20);

        //七牛图片上传token
        $assetController = new AssetController();
        $token = $assetController->upToken();

        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i<2; $i++){
            $random[] = uniqid();  //获取唯一字符串
        }

        //操作用户ID
        $user_id = Auth::user()->id;

        return view('home/purchase.supplier',['suppliers' =>$suppliers,'token' =>$token, 'random' => $random,'user_id' => $user_id]);
    }

    //未审核供应商信息列表
    public function verifyList()
    {
        $suppliers = SupplierModel::where('status',1)->orderBy('id','desc')->paginate(20);

        //七牛图片上传token
        $assetController = new AssetController();
        $token = $assetController->upToken();

        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i<2; $i++){
            $random[] = uniqid();  //获取唯一字符串
        }

        //操作用户ID
        $user_id = Auth::user()->id;
        return view('home/purchase.verifySupplier',['suppliers' =>$suppliers,'token' =>$token, 'random' => $random,'user_id' => $user_id]);

    }

    /**
     * 已关闭的使用的供应商列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function closeList()
    {
        $suppliers = SupplierModel::where('status',3)->orderBy('id','desc')->paginate(20);

        return view('home/purchase.closeSupplier',['suppliers' => $suppliers]);
    }


    /**
     *审核供应商信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxVerify(Request $request)
    {
        $supplier_id_array = $request->input('supplier');
        foreach ($supplier_id_array as $id){
            $supplierModel = new SupplierModel();
            if(!$supplierModel->verify($id)){
                return ajax_json('0','审核失败');
            }
        }
        return ajax_json('1','ok');
    }

    /**
     * 供应商关闭使用
     *
     * @param Request $request
     * @return string
     */
    public function ajaxClose(Request $request)
    {
        $id = $request->input('id');
        $supplierModel = new SupplierModel();
        if(!$supplierModel->close($id)){
            return ajax_json('0','关闭失败');
        }
        return ajax_json('1','ok');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(SupplierRequest $request)
    {
        $supplier = new SupplierModel();
        $supplier->name = $request->input('name');
        $supplier->address = $request->input('address');
        $supplier->ein = $request->input('ein');
        $supplier->bank_number = $request->input('bank_number');
        $supplier->bank_address = $request->input('bank_address');
        $supplier->general_taxpayer = $request->input('general_taxpayer');
        $supplier->legal_person = $request->input('legal_person');
        $supplier->tel = $request->input('tel');
        $supplier->contact_user = $request->input('contact_user');
        $supplier->contact_number = $request->input('contact_number');
        $supplier->contact_email = $request->input('contact_email','');
        $supplier->contact_qq = $request->input('contact_qq','');
        $supplier->contact_wx = $request->input('contact_wx','');
        $supplier->type = 1;
        $supplier->user_id = Auth::user()->id;
        $supplier->status = 1;
        $supplier->summary = $request->input('summary','');

        $supplier->cover_id = $request->input('cover_id','');
        if($supplier->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $supplier->id;
                $asset->type = 5;
                $asset->save();
            }
            return back()->withInput();
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $supplier = SupplierModel::find($id);
        if (!$supplier){
            return ajax_json(0,'数据不存在');
        }
        $assets = AssetsModel::where(['target_id' => $id,'type' => 5])->get();
        foreach ($assets as $asset){
            $asset->path = config('qiniu.url') . $asset->path . config('qiniu.small');
        }
        $supplier->assets = $assets;
        return ajax_json(1,'获取成功',$supplier);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request)
    {
        $supplier = SupplierModel::find((int)$request->input('id'));
        if($supplier->update($request->all())){

            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $supplier->id;
                $asset->type = 5;
                $asset->save();
            }

            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if(SupplierModel::destroy($id)){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
    }
    
    /**
     * 按供应商名称搜索
     */
    public function search(Request $request){
        $name = $request->input('name');
        $suppliers = SupplierModel::where('name','like','%'.$name.'%')->paginate(20);
        if ($suppliers){
            return view('home/purchase.supplier',['suppliers' => $suppliers]);
        }else{
            return view('home/purchase.supplier');
        }

    }
}
