<?php

namespace App\Http\Controllers\Home\purchase;

use App\Models\SupplierModel;
use Illuminate\Http\Request;

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
        $suppliers = SupplierModel::orderBy('id','desc')->paginate(10);
        return view('home/purchase.supplier',['suppliers' =>$suppliers]);
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
        $supplier->legal_person = $request->input('legal_person');
        $supplier->tel = $request->input('tel');
        $supplier->contact_user = $request->input('contact_user');
        $supplier->contact_number = $request->input('contact_number');
        $supplier->contact_email = $request->input('contact_email','');
        $supplier->contact_qq = $request->input('contact_qq','');
        $supplier->contact_wx = $request->input('contact_wx','');
        $supplier->type = 1;
        $supplier->user_id = 1;
        $supplier->status = 1;
        $supplier->summary = $request->input('summary','');
        if($supplier->save()){
            return ajax_json(1,'添加成功');
        }else{
            return ajax_json(0,'添加失败');
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
    public function edit(Request $request)
    {
            $id = $request->input('id');
            $supplier = SupplierModel::where('id',$id)->get();
            if ($supplier){
                return ajax_json(1,'ok',$supplier);
            }
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
        $supplier = SupplierModel::find($request->input('id'));
        if($supplier->update($request->all())){
            return ajax_json(1,'更改成功');
        }else{
            return ajax_json(0,'更改失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if(SupplierModel::destroy($id)){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
    }
    
    /**
     * 按名称搜索
     */
    public function search(Request $request){
        $name = $request->input('name');
        $suppliers = SupplierModel::where('name',$name)->paginate(10);
        if ($suppliers){
            return view('home/purchase.supplier',['suppliers' => $suppliers]);
        }else{
            return view('home/purchase.supplier');
        }

    }
}
