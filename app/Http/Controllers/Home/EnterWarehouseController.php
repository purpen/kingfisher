<?php
/**
 * 入库管理
 */
namespace App\Http\Controllers\Home;

use App\Models\AllocationOutModel;
use App\Models\EnterWarehouseSkuRelationModel;
use App\Models\EnterWarehousesModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use App\Models\PurchasingWarehousingModel;
use App\Models\StorageSkuCountModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests\EnterWarehouseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        
        return view('home/storage.purchaseEnterWarehouse', [
            'enter_warehouses' => $enter_warehouses,
            'tab_menu' => $this->tab_menu,
            'number' => $number
        ]);
    }


    function getOutWarehousesData($id, $detail = false)
    {
        $enter_warehouse = EnterWarehousesModel::find($id);
        //如果是调拨单入库，检测调拨单是否已出库
        if ($enter_warehouse->type == 3) {
            //调拨单ID
            $chang_id = $enter_warehouse->target_id;
            $out_warehouse = OutWarehousesModel::where(['type' => 3, 'target_id' => $chang_id])->first();
            if (!$out_warehouse) {
                return '参数错误';
            }
            if ($out_warehouse->storage_status == 0) {
                return '调拨仓库还没有出库，不能入库操作';
            }
        }

        $enter_warehouse->changeWarehouse_id = $enter_warehouse->changeWarehouse ? $enter_warehouse->changeWarehouse->id : '';
        $enter_warehouse->changeWarehouse_department = $enter_warehouse->changeWarehouse ? $enter_warehouse->changeWarehouse->in_department : '';//调入部门
        $enter_warehouse->purchase_id = $enter_warehouse->purchase ? $enter_warehouse->purchase->id : '';
        $enter_warehouse->purchase_department = $enter_warehouse->purchase ? $enter_warehouse->purchase->department : '';
        $enter_warehouse->storage_id = $enter_warehouse->storage ? $enter_warehouse->storage->id : '';
        $enter_warehouse->storage_name = $enter_warehouse->storage ? $enter_warehouse->storage->name : '';
        $enter_warehouse->not_count = $enter_warehouse->count - $enter_warehouse->in_count;
        // 获取明细
        $enter_sku = $enter_warehouse->enterWarehouseSkus()->get();
        $sku_model = new ProductsSkuModel();
        $enter_skus = $sku_model->detailedSku($enter_sku);
        foreach ($enter_sku as $sku) {
            $sku->not_count = $sku->count - $sku->in_count;
        }

        $returnData = ['enter_warehouse' => $enter_warehouse,
            'enter_skus' => $enter_skus,
            'tab_menu' => $this->tab_menu,
            'number' => ''
        ];
        $res = [];
        if ($detail && $enter_warehouse->purchase_id) {//返回采购单历史记录
            $purchasing = PurchasingWarehousingModel::where('purchases_id', $enter_warehouse->purchase_id)->select('id', 'user_id', 'storage_time', 'purchases_id', 'number as num')->orderBy('id', 'ASC')->get();

            if (count($purchasing) > 0) {
                $are = $purchasing->toArray();
                foreach ($are as $key => &$val) {
                    $sku_num = json_decode($val['num'], true);

                    $name = UserModel::where('id', $val['user_id'])->select('realname')->first();
//                $data=array_merge($val,['realname' => $name->realname]);
//                $res[$val['storage_time']]['data_base'] = [$data];
//                $res[$val['storage_time']]['data'][] = $data;
                    $res[] = array_merge($val, ['realname' => $name->realname, 'sku_num' => $sku_num]);
                }

                $nums = array_column($are, 'num');;
                $pop = array_pop($nums);
                $sku_arr = json_decode($pop);

                $sku_model = new ProductsSkuModel();
                $orders_sku = $sku_model->detailedSku($sku_arr);
                $ordersSku = objectToArray($orders_sku);

                foreach ($orders_sku as $key => $val) {
                    $orders_sku[$key] = (array)($val);
                }
                foreach ($res as $key => $val) {
                    $res[$key]['orders_sku'] = $orders_sku;
                }
                foreach ($res as &$item) {
                    foreach ($item['sku_num'] as $item1) {
                        foreach ($item['orders_sku'] as &$item2) {
                            if ($item1['sku_id'] == $item2['sku_id']) {
                                $item2['nums'] = $item1['number'];
                            }
                        }
                    }
                }
            }
        } elseif ($detail && $enter_warehouse->changeWarehouse_id) {//返回调拨单历史记录
            $allocation_out = AllocationOutModel::where('allocation_id', $enter_warehouse->changeWarehouse_id)->where('type', 1)->select('id', 'user_id', 'outorin_time', 'allocation_id', 'number as num')->orderBy('id', 'ASC')->get();

            if (count($allocation_out) > 0) {
                $all_out = $allocation_out->toArray();
                foreach ($all_out as $key => &$val) {
                    $sku_num = json_decode($val['num'], true);
                    $name = UserModel::where('id', $val['user_id'])->select('realname')->first();
//                $data=array_merge($val,['realname' => $name->realname]);
//                $res[$val['outorin_time']]['data_base'] = [$data];
//                $res[$val['outorin_time']]['data'][] = $data;
                    $res[] = array_merge($val, ['realname' => $name->realname, 'sku_num' => $sku_num]);
                }

                $nums = array_column($all_out, 'num');;
                $pop = array_pop($nums);
                $sku_arr = json_decode($pop);

                $sku_model = new ProductsSkuModel();
                $orders_sku = $sku_model->detailedSku($sku_arr);
                $ordersSku = objectToArray($orders_sku);

                foreach ($orders_sku as $key => $val) {
                    $orders_sku[$key] = (array)($val);
                }
                foreach ($res as $key => $val) {
                    $res[$key]['orders_sku'] = $orders_sku;
                }
                foreach ($res as &$item) {
                    foreach ($item['sku_num'] as $item1) {
                        foreach ($item['orders_sku'] as &$item2) {
                            if ($item1['sku_id'] == $item2['sku_id']) {
                                $item2['nums'] = $item1['number'];
                            }
                        }
                    }
                }
            }
        }
        $returnData['res'] = $res;

        return $returnData;
    }

    /**
     * 采购/调拨入库单编辑入库明细展示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPurchase(Request $request, $id)
    {
        $data = $this->getOutWarehousesData($id);
        return view('home.storage.purchasingWarehousing', $data );
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
        if (empty($enter_warehouse_id)) {
            return ajax_json(0, '参数错误');
        }

        $enter_warehouse = EnterWarehousesModel::find($enter_warehouse_id);
        if (!$enter_warehouse) {
            return ajax_json(0, '参数错误');
        }

        //如果是调拨单入库，检测调拨单是否已出库
        if ($enter_warehouse->type == 3) {
            //调拨单ID
            $chang_id = $enter_warehouse->target_id;
            $out_warehouse = OutWarehousesModel::where(['type' => 3, 'target_id' => $chang_id])->first();
            if (!$out_warehouse) {
                return ajax_json(0, '参数错误');
            }
            if ($out_warehouse->storage_status == 0) {
                return ajax_json(0, '调拨仓库还没有出库，不能入库操作');
            }

        }

        $enter_warehouse->storage_name = $enter_warehouse->storage->name;
        $enter_warehouse->not_count = $enter_warehouse->count - $enter_warehouse->in_count;

        $enter_sku = $enter_warehouse->enterWarehouseSkus()->get();
        if (!$enter_sku) {
            return ajax_json(0, '参数错误');
        }

        $sku_model = new ProductsSkuModel();
        $enter_sku = $sku_model->detailedSku($enter_sku);

        foreach ($enter_sku as $sku) {
            $sku->not_count = $sku->count - $sku->in_count;
        }

        $data = ['enter_warehouse' => $enter_warehouse, 'enter_sku' => $enter_sku];
        return ajax_json(1, 'ok', $data);
    }


    /**
     * 获取出库单打印信息
     *
     * @param Request $request
     * @return string
     */
    public function ajaxPrintInfo(Request $request)
    {
        $enter_warehouse_id = (int)$request->input('enter_warehouse_id');
        if(empty($enter_warehouse_id)){
            return ajax_json(0,'参数错误');
        }

        $enter_warehouse = EnterWarehousesModel::find($enter_warehouse_id);
        if(!$enter_warehouse){
            return ajax_json(0, '参数错误');
        }

        $enter_warehouse->storage_name = $enter_warehouse->storage->name;
        $enter_warehouse->not_count = $enter_warehouse->count - $enter_warehouse->in_count;

        $enter_sku = $enter_warehouse->enterWarehouseSkus()->get();
        if (!$enter_sku) {
            return ajax_json(0, '参数错误');
        }

        $sku_model = new ProductsSkuModel();
        $enter_sku = $sku_model->detailedSku($enter_sku);

        foreach ($enter_sku as $sku) {
            $sku->not_count = $sku->count - $sku->in_count;
        }

        $supplier = null;
        $out_warehouse = null;
        // 采购单
        if ($enter_warehouse->type == 1) {
            $purchase = PurchaseModel::find($enter_warehouse->target_id);
            $supplier = $purchase->supplier;
        } //        采购退货
        elseif ($enter_warehouse->type == 2) {

        } // 调拨单
        elseif ($enter_warehouse->type == 3) {
            $chang_id = $enter_warehouse->target_id;
            $out_warehouse = OutWarehousesModel::where(['type' => 3, 'target_id' => $chang_id])->first();
            $out_warehouse->storage_name = $enter_warehouse->storage->name;
        }

        $data = [
            'enter_warehouse' => $enter_warehouse,
            'enter_sku' => $enter_sku,
            'supplier' => $supplier,
            'out_warehouse' => $out_warehouse,
        ];

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
        $storage_id = $request->input('storage_id');
        $purchase_id = $request->input('purchase_id');
        $purchase_department = $request->input('purchase_department');

        $changeWarehouse_id = $request->input('changeWarehouse_id');
        $changeWarehouse_department = $request->input('changeWarehouse_department');
        // 入库单明细ID
        $enter_sku_id_arr = $request->input('enter_sku_id');
        $sku_id_arr = array_values($request->input('sku_id'));
        $count_arr = array_values($request->input('count'));
        
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

        for ($i=0;$i< count($sku_id_arr);$i++){
            $sku_num = [
                'sku_id' =>$sku_id_arr[$i],
                'number' => $count_arr[$i],
            ];
            $arr[] = $sku_num;
        }

        if ($enter_warehouse_model->type == 1){//采购入库
            $purchasing_warehousing = new PurchasingWarehousingModel();
            $purchasing_warehousing->user_id = Auth::user()->id;
            $purchasing_warehousing->storage_id = $storage_id;
            $purchasing_warehousing->purchases_id = $purchase_id;
            $purchasing_warehousing->department = $purchase_department;
            $purchasing_warehousing->storage_time = date("Y-m-d H:i:s");
            $purchasing_warehousing->number = json_encode($arr);
            if (!$purchasing_warehousing->save()) {
                DB::rollBack();
                return view('errors.503');
            }
        }elseif ($enter_warehouse_model->type == 3){//调拨入库
            $allocation_out = new AllocationOutModel();
            $allocation_out->user_id = Auth::user()->id;
            $allocation_out->storage_id = $storage_id;
            $allocation_out->allocation_id = $changeWarehouse_id;
            $allocation_out->department = $changeWarehouse_department;
            $allocation_out->type = 1;
            $allocation_out->outorin_time = date("Y-m-d H:i:s");
            $allocation_out->number = json_encode($arr);
            if (!$allocation_out->save()) {
                DB::rollBack();
                return view('errors.503');
            }
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
        return redirect('/enterWarehouse');
//        return back()->withInput();
    }

    /**
     * 采购入库单详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
//        $enter_warehouse = EnterWarehousesModel::find($id);
//        // 获取明细
//        $enter_sku = $enter_warehouse->enterWarehouseSkus()->get();
//
//        $sku_model = new ProductsSkuModel();
//        $enter_skus = $sku_model->detailedSku($enter_sku);
//
//        return view('home.storage.enter_warehouse_show', [
//            'enter_warehouse' => $enter_warehouse,
//            'enter_skus' => $enter_skus,
//            'tab_menu' => $this->tab_menu,
//            'number' => ''
//        ]);

        $data = $this->getOutWarehousesData($id,true);
        return view('home.storage.enter_warehouse_show', $data );
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
