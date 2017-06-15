<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Models\AssetsModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public $tab_menu = 'default';

    /**
     * 查询当前用户所在部门创建的供应商
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newQuery()
    {
        //当前登陆用户所属部门
        $department = Auth::user()->department;
        if($department){
            $id_arr = UserModel::where('department',$department)->get()->pluck('id')->toArray();
            $query = SupplierModel::whereIn('user_id', $id_arr);
        }else{
            $query = SupplierModel::query();
        }
        return $query;
    }

    public function index()
    {
        $this->tab_menu = 'verified';
        $suppliers = $this->newQuery()->where('status',2)->orderBy('id','desc')->paginate(20);

        return $this->display_tab_list($suppliers);
    }

    //未审核供应商信息列表
    public function verifyList()
    {
        $this->tab_menu = 'verifying';
        $suppliers = $this->newQuery()->where('status',1)->orderBy('id','desc')->paginate(20);

        return $this->display_tab_list($suppliers);

    }

    /**
     * 已关闭的使用的供应商列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function closeList()
    {
        $this->tab_menu = 'close';
        $suppliers = $this->newQuery()->where('status',3)->orderBy('id','desc')->paginate(20);

        return $this->display_tab_list($suppliers);
    }

    public function display_tab_list($suppliers)
    {
        $nam = '';
        //七牛图片上传token
        $token = QiniuApi::upToken();

        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i<2; $i++){
            $random[] = uniqid();  //获取唯一字符串
        }

        //操作用户ID
        $user_id = Auth::user()->id;

        return view('home/supplier.supplier',[
            'suppliers' => $suppliers,
            'token' =>$token,
            'random' => $random,
            'user_id' => $user_id,
            'tab_menu' => $this->tab_menu,
            'nam' => $nam
        ]);
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
            $supplierModel = SupplierModel::find($id);

            if($supplierModel->status != 1){
                return ajax_json(0,'警告：该供应商无法审核！');
            }
            if(empty($supplierModel->cover_id)){
                return ajax_json(0,'警告：未上传合作协议扫描件，无法通过审核！');
            }

            if(!$supplierModel->verify($id)){
                return ajax_json(0,'警告：审核失败');
            }

        }
        
        return ajax_json(1,'ok');
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
    public function create()
    {
        //七牛图片上传token
        $token = QiniuApi::upToken();

        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i<2; $i++){
            $random[] = uniqid();  //获取唯一字符串
        }

        $user_list = UserModel::ofStatus(1)->select('id','realname')->get();

        //操作用户ID
        $user_id = Auth::user()->id;
        return view('home/supplier.createSupplier',[
            'token' => $token , 
            'random' => $random, 
            'user_id' => $user_id,
            'tab_menu' => $this->tab_menu,
            'nam' => '',
            'user_list' => $user_list,
        ]);
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
        $supplier->nam = $request->input('nam');
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
        $supplier->type = $request->input('type');
        $supplier->user_id = Auth::user()->id;
        $supplier->status = 1;
        $supplier->summary = $request->input('summary','');

        $supplier->cover_id = $request->input('cover_id','');
        $supplier->discount = $request->input('discount');
        $supplier->tax_rate = $request->input('tax_rate');
        $supplier->start_time = $request->input('start_time');
        $supplier->end_time = $request->input('end_time');
        $supplier->relation_user_id = $request->input('relation_user_id');
        $supplier->random_id = str_random(6);
        if($supplier->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $supplier->id;
                $asset->type = 5;
                $asset->save();
            }
            return redirect('/supplier/verifyList');
        }else{
            return "添加失败";
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
        $supplier = SupplierModel::find($id);

        //七牛图片上传token
        $token = QiniuApi::upToken();
        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i<2; $i++){
            $random[] = uniqid();  //获取唯一字符串
        }
        //操作用户ID
        $user_id = Auth::user()->id;
        if (!$supplier){
            return ajax_json(0,'数据不存在');
        }
        $assets = AssetsModel::where(['target_id' => $id,'type' => 5])->get();
        foreach ($assets as $asset){
            $asset->path = $asset->file->srcfile;
        }
        $supplier->assets = $assets;

        $user_list = UserModel::ofStatus(1)->select('id','realname')->get();
        
        return view('home/supplier.editSupplier', [
            'supplier' => $supplier, 
            'random' => $random,
            'token' => $token,
            'user_id' => $user_id,
            'tab_menu' => $this->tab_menu,
            'nam' => '',
            'user_list' => $user_list,
        ]);
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
        $all = $request->all();
        if($all['cover_id'] == ''){
            unset($all['cover_id']);
        }
        if($supplier->update($all)){

            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $supplier->id;
                $asset->type = 5;
                $asset->save();
            }

            return redirect('/supplier');
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
        //七牛图片上传token
        $token = QiniuApi::upToken();

        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i<2; $i++){
            $random[] = uniqid();  //获取唯一字符串
        }

        //操作用户ID
        $user_id = Auth::user()->id;

        $nam = $request->input('nam');
        $suppliers = SupplierModel::where('nam','like','%'.$nam.'%')->paginate(20);
        if ($suppliers){
            return view('home/supplier.supplier',[
                'suppliers' => $suppliers,
                'tab_menu' => $this->tab_menu,
                'token' =>$token,
                'random' => $random,
                'user_id' => $user_id,
                'nam' => $nam
            ]);
        }else{
            return view('home/supplier.supplier');
        }

    }

    /**
     * 监控供应商列表
     */
    public function suppliersLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = SupplierModel::query();
        $suppliers = $lists->paginate($per_page);
        return view('home/monitorLists.suppliers' , [
            'suppliers' => $suppliers,
        ]);

    }

    /**
     *  供应商详情
     */
    public function showSuppliers(Request $request)
    {
        $id = $request->input('id');
        $supplier = SupplierModel::where('id' , $id)->first();

        return view('home/monitorDetails.supplier',[
            'supplier' => $supplier,

        ]);
    }
}
