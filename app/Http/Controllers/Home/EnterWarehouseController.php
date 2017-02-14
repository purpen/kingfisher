<?php
/**
 * 入库管理
 */
namespace App\Http\Controllers\Home;

use App\Models\EnterWarehouseSkuRelationModel;
use App\Models\EnterWarehousesModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Http\Request;

use App\Http\Requests\EnterWarehouseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EnterWarehouseController extends Controller
{
    /**
     * 初始化构造
     */
    public function __construct()
    {
        // 设置菜单状态
        View()->share('tab_menu', 'active');
    }   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->home($request);
    }
    
    /**
     * 待入库列表
     */
    public function home(Request $request)
    {
        $this->tab_menu = 'waiting';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(5, 1);   
    }

    /**
     * 调拨入库列表
     */
    public function changeEnter(Request $request)
    {
        $this->tab_menu = 'exchange';
        $per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(5, 3);
    }
    
    /**
     * 完成入库列表
     */
    public function complete(Request $request)
    {
        $this->tab_menu = 'completed';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(5, 0);
    }
    
    /*
     * 完成入库单搜索
     */
    public function search(Request $request)
    {
        $number = $request->input('number');
        $enter_warehouses = EnterWarehousesModel::where('number','like','%'.$number.'%')->paginate(20);
        return view('home/storage.completeEnterWarehouse',[
            'enter_warehouses' => $enter_warehouses,
            'number' => $number
        ]);
    }
    
    /**
     * 获取列表数据
     */
    protected function display_tab_list($status, $type=1)
    {
        $number = '';
        if ($type) {
            $enter_warehouses = EnterWarehousesModel::OfType($type)->where('storage_status', '!=', $status)->paginate($this->per_page);
        } else {
            $enter_warehouses = EnterWarehousesModel::where('storage_status', $status)->orderBy('id','desc')->paginate($this->per_page);
        }
        
//        switch ($this->tab_menu) {
//            case 'completed':
//                $blade = 'home/storage.completeEnterWarehouse';
//                break;
//            case 'waiting':
//                $blade = 'home/storage.purchaseEnterWarehouse';
//                break;
//            case 'exchange':
//                $blade = 'home/storage.changeEnterWarehouse';
//                break;
//        }
        
        return view('home/storage.purchaseEnterWarehouse', [
            'enter_warehouses' => $enter_warehouses,
            'tab_menu' => $this->tab_menu,
            'number' => $number
        ]);
    }


    /**
     * 获取入库单详细信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxEdit(Request $request)
    {
        $enter_warehouse_id = (int)$request->input('enter_warehouse_id');
        if(empty($enter_warehouse_id)){
            return ajax_json(0,'参数错误');
        }

        $enter_warehouse = EnterWarehousesModel::find($enter_warehouse_id);
        if(!$enter_warehouse){
            return ajax_json(0, '参数错误');
        }

        //如果是调拨单入库，检测调拨单是否已出库
        if($enter_warehouse->type == 3){
            //调拨单ID
            $chang_id = $enter_warehouse->target_id;
            $out_warehouse = OutWarehousesModel::where(['type' => 3,'target_id' => $chang_id])->first();
            if(!$out_warehouse){
                return ajax_json(0, '参数错误');
            }
            if($out_warehouse->storage_status == 0){
                return ajax_json(0, '调拨仓库还没有出库，不能入库操作');
            }

        }
        
        $enter_warehouse->storage_name = $enter_warehouse->storage->name;
        $enter_warehouse->not_count = $enter_warehouse->count - $enter_warehouse->in_count;

        $enter_sku = $enter_warehouse->enterWarehouseSkus()->get();
        if(!$enter_sku){
            return ajax_json(0, '参数错误');
        }

        $sku_model = new ProductsSkuModel();
        $enter_sku = $sku_model->detailedSku($enter_sku);
        
        foreach ($enter_sku as $sku){
            $sku->not_count = $sku->count - $sku->in_count;
        }

        $data = ['enter_warehouse' => $enter_warehouse, 'enter_sku' => $enter_sku];
        
        return ajax_json(1, 'ok', $data);
    }
    
    /**
     * 编辑入库
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EnterWarehouseRequest $request)
    {
        $enter_warehouse_id = (int)$request->input('enter_warehouse_id');

        $summary = $request->input('summary');
        // 入库单明细ID
        $enter_sku_id_arr = $request->input('enter_sku_id');
        $sku_id_arr = $request->input('sku_id');
        $count_arr = $request->input('count');
        
        $sum = 0;
        foreach ($count_arr as $count){
            $sum = $sum + $count;
        }
        
        // 查询入库单信息
        $enter_warehouse_model = EnterWarehousesModel::find($enter_warehouse_id);
        if (!$enter_warehouse_model) {
            return view('errors.503');
        }
        
        // 验证数量是否一致
        if ($sum > ($enter_warehouse_model->count - $enter_warehouse_model->in_count)){
            return view('errors.503');
        }
        
        $enter_warehouse_model->in_count = $enter_warehouse_model->in_count + $sum;
        $enter_warehouse_model->summary = $summary;
        
        // 开启事务
        DB::beginTransaction();
        if (!$enter_warehouse_model->save()) {
            DB::rollBack();
            return view('errors.503');
        }
        $sku_arr = [];                 
        // sku主键 和 sku入库数量 键值对 数组
        for ($i=0; $i<count($enter_sku_id_arr); $i++) {
            $enter_sku = EnterWarehouseSkuRelationModel::find($enter_sku_id_arr[$i]);
            // 1、验证入库单是否存在
            if (!$enter_sku) {
                DB::rollBack();
                return view('errors.503');
            }
            // 2、验证入库数量是否一致
            if ($count_arr[$i] > $enter_sku->count - $enter_sku->in_count) {
                DB::rollBack();
                return view('errors.503');
            }
            // 3、更新入库数量
            $enter_sku->in_count = $enter_sku->in_count + $count_arr[$i];
            if (!$enter_sku->save()) {
                DB::rollBack();
                return view('errors.503');
            }

            // 增加商品，SKU 总库存
            $skuModel = new ProductsSkuModel();
            if(!$skuModel->addInventory($sku_id_arr[$i],$count_arr[$i])){
                DB::rollBack();
                return view('errors.503');
            }

            $sku_arr[$sku_id_arr[$i]] = $count_arr[$i];
        }
        
        // 修改入库单入库状态、相关单据入库数量、入库状态、明细入库数量
        if (!$enter_warehouse_model->setStorageStatus($sku_arr)) {
            DB::rollBack();
            return view('errors.503');
        }

        // 增加对应仓库/部门的SKU库存   （添加sku 部门类型 --2017.2.13）
        $storage_id = $enter_warehouse_model->storage_id;
        $department = $enter_warehouse_model->department;
        $storage_sku_count = new StorageSkuCountModel();
        if (!$storage_sku_count->enter($storage_id, $department, $sku_arr)) {
            DB::rollBack();
            return view('errors.503');
        }
        // 事务结束
        DB::commit();

        return back()->withInput();
    }

    /**
     * 采购入库单详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $enter_warehouse = EnterWarehousesModel::find($id);
        // 获取明细
        $enter_sku = $enter_warehouse->enterWarehouseSkus()->get();

        $sku_model = new ProductsSkuModel();
        $enter_skus = $sku_model->detailedSku($enter_sku);
        
        return view('home.storage.enter_warehouse_show', [
            'enter_warehouse' => $enter_warehouse,
            'enter_skus' => $enter_skus,
            'tab_menu' => $this->tab_menu,
            'number' => ''
        ]);
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
}
