<?php

namespace App\Http\Controllers\Home;

use App\Helper\QiniuApi;
use App\Models\AssetsModel;
use App\Models\OrderMould;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsModel;
use App\Models\SupplierModel;
use App\Models\SupplierMonthModel;
use App\Models\UserModel;
use Dingo\Api\Routing\Adapter\Laravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
//    public $tab_menu = 'default';

    /**
     * 查询当前用户所在部门创建的供应商
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newQuery()
    {
        //当前登陆用户所属部门
//        $department = Auth::user()->department;
//        if($department){
//            $id_arr = UserModel::where('department',$department)->get()->pluck('id')->toArray();
//            $query = SupplierModel::whereIn('user_id', $id_arr);
//        }else{
        $query = SupplierModel::query();
//        }
        return $query;
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $this->tab_menu = 'verified';
        if(!in_array($status,[1,2,3,4])){

            $suppliers = $this->newQuery()->orderBy('id', 'desc')->paginate($this->per_page);
        }else{
            $suppliers = $this->newQuery()->where('status', $status)->orderBy('id', 'desc')->paginate($this->per_page);
        }

        return $this->display_tab_list($suppliers , $status);
    }

    public function display_tab_list($suppliers , $status)
    {
        $nam = '';
        //七牛图片上传token
        $token = QiniuApi::upToken();

        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i < 2; $i++) {
            $random[] = uniqid();  //获取唯一字符串
        }
        $order_moulds = OrderMould::mouldList();

        //操作用户ID
        $user_id = Auth::user()->id;

        return view('home/supplier.supplier', [
            'suppliers' => $suppliers,
            'token' => $token,
            'random' => $random,
            'user_id' => $user_id,
            'tab_menu' => $this->tab_menu,
            'nam' => $nam,
            'status' => $status,
            'order_moulds' => $order_moulds,
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
        $supplier_id_array = $request->input('supplier')?$request->input('supplier'):'';
        $msg=$request->input("msg");
        if ($supplier_id_array !='') {
            foreach ($supplier_id_array as $id) {
                $supplierModel = SupplierModel::find($id);

//            if ($supplierModel->status != 1) {
//                return ajax_json(0, '警告：该供应商无法审核！');
//            }
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

    /**
     * 供应商关闭使用
     *
     * @param Request $request
     * @return string
     */
    public function ajaxClose(Request $request)
    {
        $supplier_id_array = $request->input('supplier')?$request->input('supplier'):'';

        $msg = $request->input("msg");

        if ($supplier_id_array != '') {
            foreach ($supplier_id_array as $id) {
                $supplierModel = new SupplierModel();
                if (!$supplierModel->close($id)) {
                    return ajax_json('0', '关闭失败');//'0'?
                }
            }
        }else{
            return ajax_json(1, '您还没有勾选供应商！');
        }
        $ins = str_repeat('?,', count($supplier_id_array) - 1) . '?';
        $bind_values = array_merge([$msg], $supplier_id_array);
        $arr = DB::update("update suppliers set msg=? where id IN ($ins)", $bind_values);
        return ajax_json(0, '操作成功');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //七牛图片上传token
        $token = QiniuApi::upToken();
        $status = $request->input('status');

        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i < 2; $i++) {
            $random[] = uniqid();  //获取唯一字符串
        }

        $user_list = UserModel::ofStatus(1)->select('id', 'realname' , 'phone')->get();

        $order_moulds = OrderMould::mouldList();
        $supplier_user_list = UserModel::where('supplier_distributor_type' , 2)->select('id', 'realname' , 'phone')->get();

        //操作用户ID
        $user_id = Auth::user()->id;
        $return_url = $_SERVER['HTTP_REFERER'];
        return view('home/supplier.createSupplier', [
            'token' => $token,
            'random' => $random,
            'user_id' => $user_id,
            'tab_menu' => $this->tab_menu,
            'nam' => '',
            'user_list' => $user_list,
            'order_moulds' => $order_moulds,
            'supplier_user_list' => $supplier_user_list,
            'status' => $status,
            'return_url' => $return_url,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(SupplierRequest $request)
    {
        $supplier = new SupplierModel();
        $supplier->name = $request->input('name');
        $supplier->nam = $request->input('nam');
        $supplier->address = $request->input('address');
//        $supplier->ein = $request->input('ein');
//        $supplier->bank_number = $request->input('bank_number');
//        $supplier->bank_address = $request->input('bank_address');
//        $supplier->general_taxpayer = $request->input('general_taxpayer');
        $supplier->legal_person = $request->input('legal_person');
        $supplier->tel = $request->input('tel');
        $supplier->contact_user = $request->input('contact_user');
        $supplier->contact_number = $request->input('contact_number');
        $supplier->contact_email = $request->input('contact_email', '');
        $supplier->contact_qq = $request->input('contact_qq', '');
        $supplier->contact_wx = $request->input('contact_wx', '');
        $supplier->type = $request->input('type');
        $supplier->user_id = Auth::user()->id;
        $supplier->status = 1;
        $supplier->summary = $request->input('summary', '');

        $supplier->cover_id = $request->input('cover_id', '');
        $supplier->trademark_id = $request->input('trademark_id', 0);
        $supplier->power_of_attorney_id = $request->input('power_of_attorney_id', 0);
        $supplier->quality_inspection_report_id = $request->input('quality_inspection_report_id', 0);
//        $supplier->discount = $request->input('discount');

//        $supplier->tax_rate = $request->input('tax_rate');
        $supplier->start_time = $request->input('start_time');
        $supplier->end_time = $request->input('end_time');
        $supplier->relation_user_id = $request->input('relation_user_id');
        $supplier->random_id = str_random(6);
        $supplier->mould_id = $request->input('mould_id', 0);
        $supplier->authorization_deadline = $request->input('authorization_deadline');
        $supplier_user_id = $request->input('supplier_user_id');
        $redirect_url = $request->input('return_url') ? htmlspecialchars_decode($request->input('return_url')) : null;
        if($supplier_user_id == 0){
            if ($supplier->save()) {
                $assets = AssetsModel::where('random', $request->input('random'))->get();
                foreach ($assets as $asset) {
                    $asset->target_id = $supplier->id;
                    $asset->save();
                }
                return redirect('/supplier');
            } else {
                return "添加失败";
            }
        }else{
            $sup = SupplierModel::where('supplier_user_id' , $supplier_user_id)->first();
            if($sup){
                return redirect($redirect_url)->with('error_message', '该供应商已经绑定供应商用户!');
            }
            $supplier->supplier_user_id = $supplier_user_id;
            if ($supplier->save()) {
                $assets = AssetsModel::where('random', $request->input('random'))->get();
                foreach ($assets as $asset) {
                    $asset->target_id = $supplier->id;
                    $asset->save();
                }
                return redirect('/supplier');
            } else {
                return "添加失败";
            }
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $supplier = SupplierModel::find($id);
        $status = $request->input('status');
        //七牛图片上传token
        $token = QiniuApi::upToken();
        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i < 2; $i++) {
            $random[] = uniqid();  //获取唯一字符串
        }
        //操作用户ID
        $user_id = Auth::user()->id;
        if (!$supplier) {
            return ajax_json(0, '数据不存在');
        }
        $assets = AssetsModel::where(['target_id' => $id, 'type' => 5])->get();
        $assets_trademarks = AssetsModel::where(['target_id' => $id, 'type' => 12])->get();
        $assets_power_of_attorneys = AssetsModel::where(['target_id' => $id, 'type' => 13])->get();
        $assets_quality_inspection_reports = AssetsModel::where(['target_id' => $id, 'type' => 14])->get();
//        foreach ($assets as $asset) {
//            $asset->path = $asset->file->srcfile;
//        }
//        $supplier->assets = $assets;
//        $user_list = UserModel::ofStatus(1)->select('id', 'realname','phone')->get();
//        $supplier_user_list = UserModel::where('supplier_distributor_type' , 2)->select('id', 'realname' , 'phone')->get();

        $order_moulds = OrderMould::mouldList();
        $return_url = $_SERVER['HTTP_REFERER'];
//        $return_url=$supplier['status'] == 3  ? url('/supplier?status=4') : $_SERVER['HTTP_REFERER'];
        return view('home/supplier.editSupplier', [
            'supplier' => $supplier,
            'random' => $random,
            'token' => $token,
            'user_id' => $user_id,
            'tab_menu' => $this->tab_menu,
            'nam' => '',
//            'user_list' => $user_list,
            'order_moulds' => $order_moulds,
            'status' => $status,
            'assets' => $assets,
            'assets_trademarks' => $assets_trademarks,
            'assets_power_of_attorneys' => $assets_power_of_attorneys,
            'assets_quality_inspection_reports' => $assets_quality_inspection_reports,
            'return_url' => $return_url,
//            'supplier_user_list' => $supplier_user_list,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request)
    {
        $supplier = SupplierModel::find((int)$request->input('id'));
        $all = $request->all();
//        如果状态为3 编辑之后就让它变成4 即：重新审核
        if($all['status'] == 3) {
            $all['status'] = "4";
        }
//        if ($all['cover_id'] == '') {
//            unset($all['cover_id']);
//        }
        $redirect_url = $request->input('return_url') ? htmlspecialchars_decode($request->input('return_url')) : null;
        if($all['supplier_user_id'] == 0){
            if ($supplier->update($all)) {

                if($redirect_url !== null){
                    return redirect($redirect_url);
                }else{
                    return redirect('/supplier');
                }
            }
        }else{
            //检测是否绑定供应商用户
            $sup = SupplierModel::where('supplier_user_id' , $all['supplier_user_id'])->first();
            if($sup){
                return redirect('/supplier/edit?id='.$request->input('id'))->with('error_message', '该供应商已经绑定供应商用户!');;
            }
            if ($supplier->update($all)) {

                if($redirect_url !== null){
                    return redirect($redirect_url);
                }else{
                    return redirect('/supplier');
                }
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if (SupplierModel::destroy($id)) {
            return ajax_json(1, '删除成功');
        } else {
            return ajax_json(0, '删除失败 ');
        }
    }

    /**
     * 按供应商名称搜索
     */
    public function search(Request $request)
    {
        //七牛图片上传token
        $token = QiniuApi::upToken();
        $status = $request->input('status');
        //随机字符串(回调查询)
        $random = [];
        for ($i = 0; $i < 2; $i++) {
            $random[] = uniqid();  //获取唯一字符串
        }

        //操作用户ID
        $user_id = Auth::user()->id;
        $order_moulds = OrderMould::mouldList();

        $nam = $request->input('nam');
        $suppliers = SupplierModel::where('nam', 'like', '%' . $nam . '%')->orWhere('name', 'like', '%' . $nam . '%')->orWhere('contact_user', 'like', '%' . $nam . '%')->paginate($this->per_page);
        if ($suppliers) {
            return view('home/supplier.supplier', [
                'suppliers' => $suppliers,
                'tab_menu' => $this->tab_menu,
                'token' => $token,
                'random' => $random,
                'user_id' => $user_id,
                'nam' => $nam,
                'status' => $status,
                'order_moulds' => $order_moulds,
            ]);
        } else {
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
        return view('home/monitorLists.suppliers', [
            'suppliers' => $suppliers,
        ]);

    }

    /**
     *  供应商详情
     */
    public function showSuppliers(Request $request)
    {
        $id = $request->input('id');
        $supplier = SupplierModel::where('id', $id)->first();

        return view('home/monitorDetails.supplier', [
            'supplier' => $supplier,

        ]);
    }

//    /**
//     * 代发供应商订单
//     */
//    public function suppliersOrder()
//    {
//        //检查当前的月份
//        $month = date('m');
//        //如果当前是1月份，就减去1年
//        $year = date('Y')-1;
//        //1月份走上面，其他月份走下面
//        if ($month == 1){
//            $Ym = date($year."-12");
//            $start = date("Y-m-d H:i:s", strtotime($Ym));
//            $Y_m = date("Y-m");
//            $end = date("Y-m-d H:i:s", strtotime($Y_m));
//        }else{
//            $Ym = date("Y-".($month-1));
//            $Y_m = date("Y-m");
//            $start = date("Y-m-d H:i:s", strtotime($Ym));
//            $end = date("Y-m-d H:i:s", strtotime($Y_m));
//        }
//
//        //获取代发的供应商
//        $suppliers = SupplierModel::where('type' , 3)->get();
//
//        //循环供应商列表
//        foreach ($suppliers as $supplier){
//            //供应商名称
//            $supplier_name = $supplier->name;
//
//            $sup_id = $supplier->id;
//            $product_id = [];
//            //查看代发供应商下面的商品，把商品id存入到数组里
//            $products = ProductsModel::where('supplier_id' , $sup_id)->get();
//            foreach ($products as $product){
//                $product_id[] = $product->id;
//            }
//            //查看供应商提供的商品
//            $all_total = 0;
//            $order_sku_relation = OrderSkuRelationModel::whereIn('product_id' , $product_id)->whereBetween('created_at' , [$start,$end])->get();
//            foreach ($order_sku_relation as $v){
//                $order_sku_relation_id[] = $v->id;
//                $price = $v->price;
//                $quantity = $v->quantity;
//                $total = $price * $quantity;
//                $all_total += $total;
//            }
//            //代发供应商提供的商品，每月卖出去多少钱
//            $supplierMonth = new SupplierMonthModel();
//            $supplierMonth->supplier_name = $supplier_name;
//            $supplierMonth->year_month = $Ym;
//            $supplierMonth->total_price = $all_total;
//            $supplierMonth->status = 0;
//            $supplierMonth->save();
//
//        }
//
//    }


    /**
     * 代发供应商每月统计列表
     */
    public function supplierMonthLists()
    {
        $tab_menu = 'yes';
        $supplierMonths = SupplierMonthModel::where('status', 1)->orderBy('year_month', 'desc')->paginate(20);

        return view('home/supplier.supplierMonth', [
            'supplierMonths' => $supplierMonths,
            'tab_menu' => $tab_menu,
        ]);
    }

    /**
     * 代发供应商每月未确认统计列表
     */
    public function noSupplierMonthLists()
    {
        $tab_menu = 'no';
        $supplierMonths = SupplierMonthModel::where('status', 0)->orderBy('year_month', 'desc')->paginate($this->per_page);

        return view('home/supplier.supplierMonth', [
            'supplierMonths' => $supplierMonths,
            'tab_menu' => $tab_menu,

        ]);
    }

    /**
     * 供应商确认月统计
     */
    public function status($id)
    {
        $ok = SupplierMonthModel::status($id, 0);
        return back()->withInput();
    }

    public function noStatus($id)
    {
        $ok = SupplierMonthModel::noStatus($id, 1);
        return back()->withInput();
    }

    /**
     * 详情
     */
    public function details(Request $request)
    {
        $id = $request->input('id');
        $supplier = SupplierModel::where('id' , $id)->first();

        return view('home/supplier.details', [
            'supplier' => $supplier,
        ]);


    }

    //检测供应商是否注册过
    public function testSupplier(Request $request)
    {
        $name = $request->input('name');
        $supplier = SupplierModel::where('name' , $name)->first();
        if (!$supplier) {
            return ajax_json(1, '供应商不存在，可以填写');
        } else {
            return ajax_json(0, '供应商已存在，不能填写');
        }
    }

    //绑定模版get
    public function addMould(Request $request)
    {
        $id = $request->input('id');
        $supplier = SupplierModel::find($id);
        if ($supplier) {
            return ajax_json(1, '获取成功', $supplier);
        } else {
            return ajax_json(0, '数据不存在');
        }
    }

    //绑定模版post
    public function storeMould(Request $request)
    {
        $supplier_id = $request->input('supplier_id');
        $mould_id = $request->input('mould_id');
        $supplier = SupplierModel::where('id' , $supplier_id)->first();
        if(!$supplier){
            return back()->with('error_message', '没有找到该供应商！')->withInput();
        }else{
            $supplier->mould_id = $mould_id;
            if($supplier->save()){
                return back()->with('error_message', '绑定成功')->withInput();
            }
        }

    }

    //绑定用户
    public function addUser(Request $request)
    {
        $supplier_id = $request->input('id');
        $supplier = SupplierModel::where('id' , intval($supplier_id))->first();
        if(!$supplier){
            return ajax_json(0, '供应商不存在');
        }
        //供应商手机号
        $phone = $supplier->contact_number;
        $userPhone = UserModel::where('account' , $phone)->first();
        if($userPhone){
            return ajax_json(0, '该供应商已生成账户');
        }
        //根据手机好创建账户
        $user = new UserModel();
        $user->account = $phone;
        $user->phone = $phone;
        //密码为手机号后六位
        $user->password = bcrypt(substr($phone , -6));
        $user->type = 0;
        $user->status = 1;
        $user->supplier_distributor_type = 2;
        if($user->save()){
            $supplier->supplier_user_id = $user->id;
            $supplier->save();
            return ajax_json(1, '生成成功');
        }
    }

}
