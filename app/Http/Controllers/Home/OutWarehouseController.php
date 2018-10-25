<?php

namespace App\Http\Controllers\Home;

use App\Helper\KdnOrderTracesSub;
use App\Jobs\PushExpressInfo;
use App\Models\AllocationOutModel;
use App\Models\ChangeWarehouseModel;
use App\Models\ChinaCityModel;
use App\Models\ConsignorModel;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\OrderOutModel;
use App\Models\OutgoingLogisticsModel;
use App\Models\OutWarehouseSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Http\Request;

use App\Http\Requests\OutWarehouseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OutWarehouseController extends Controller
{
    /**
     * 显示列表
     */
    public function index(Request $request)
    {
        return $this->home($request);
    }

    /**
     * 采购单 出库列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Request $request)
    {
        $this->tab_menu = 'waiting';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list();
    }

    /**
     * 订单产生的出库列表
     */
    public function orderOut(Request $request)
    {
        $this->tab_menu = 'saled';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(2);
    }

    /**
     * 调拨出库列表
     */
    public function changeOut(Request $request)
    {
        $this->tab_menu = 'exchanged';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(3);
    }

    /**
     * 已完成出库列表
     */
    public function complete(Request $request)
    {
        $where = '';
        $this->tab_menu = 'finished';
        $this->per_page = $request->input('per_page', $this->per_page);

        $out_warehouses = OutWarehousesModel::where('storage_status', 5)->orderBy('id', 'desc')->paginate($this->per_page);

        foreach ($out_warehouses as $out_warehouse) {
            switch ($out_warehouse->type) {
                case 1:
                    if ($out_warehouse->returnedPurchase) {
                        $out_warehouse->returned_number = $out_warehouse->returnedPurchase->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                case 2:
                    if ($out_warehouse->order) {
                        $out_warehouse->returned_number = $out_warehouse->order->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                case 3:
                    if ($out_warehouse->changeWarehouse) {
                        $out_warehouse->returned_number = $out_warehouse->changeWarehouse->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                default:
                    return view('errors.503');
            }
            if ($out_warehouse->order) {
                $out_warehouse->order_send_time = $out_warehouse->order->order_send_time;
            } else {
                $out_warehouse->order_send_time = '';
            }
            $out_warehouse->storage_name = $out_warehouse->storage->name;
            if ($out_warehouse->user) {
                $out_warehouse->user_name = $out_warehouse->user->realname;
            } else {
                $out_warehouse->user_name = '';
            }

        }

        return view('home/storage.returnedOutWarehouse', [
            'out_warehouses' => $out_warehouses,
            'tab_menu' => $this->tab_menu,
            'where' => $where,
            'logistics_list' => [],
        ]);
    }

    /**
     * 列表显示
     */
    protected function display_tab_list($type = 1)
    {
        $where = '';
        $out_warehouses = OutWarehousesModel::where('type', $type)->where('storage_status', '!=', 5)->paginate($this->per_page);

        foreach ($out_warehouses as $out_warehouse) {
            switch ($out_warehouse->type) {
                case 1:
                    if ($out_warehouse->returnedPurchase) {
                        $out_warehouse->returned_number = $out_warehouse->returnedPurchase->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                case 2:
                    if ($out_warehouse->order) {
                        $out_warehouse->returned_number = $out_warehouse->order->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                case 3:
                    if ($out_warehouse->changeWarehouse) {
                        $out_warehouse->returned_number = $out_warehouse->changeWarehouse->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
            }
            $out_warehouse->storage_name = $out_warehouse->storage ? $out_warehouse->storage->name : '';
            if ($out_warehouse->user) {
                $out_warehouse->user_name = $out_warehouse->user->realname;
            } else {
                $out_warehouse->user_name = '';
            }

        }

        $logistics_list = $logistic_list = LogisticsModel::OfStatus(1)->select(['id', 'name'])->get();

        return view('home/storage.returnedOutWarehouse', [
            'out_warehouses' => $out_warehouses,
            'tab_menu' => $this->tab_menu,
            'where' => $where,
            'logistics_list' => $logistics_list,
        ]);
    }

    /**
     * 订单出库单编辑出库明细展示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOut(Request $request, $id)
    {
        $out_warehouse = OutWarehousesModel::find($id);
        //判断是否审核通过
        if ($out_warehouse->status == 0) {
            return '尚未审核';
        }
        $province_id = $out_warehouse->order ? $out_warehouse->order->buyer_province : '';
        $city_id = $out_warehouse->order ? $out_warehouse->order->buyer_city : '';
        $county_id = $out_warehouse->order ? $out_warehouse->order->buyer_county : '';
        $town_id = $out_warehouse->order ? $out_warehouse->order->buyer_township : '';
        $address = $out_warehouse->order ? $out_warehouse->order->buyer_address : '';
        $province = ChinaCityModel::where('oid', $province_id)->select('name')->first();
        $city = ChinaCityModel::where('oid', $city_id)->select('name')->first();
        $county = ChinaCityModel::where('oid', $county_id)->select('name')->first();
        $town = ChinaCityModel::where('oid', $town_id)->select('name')->first();

        $province_name = $province ? $province->name : '';
        $city_name = $city ? $city->name : '';
        $county_name = $county ? $county->name : '';
        $town_name = $town ? $town->name : '';
        $out_warehouse->full_address = $province_name.' '.$city_name.' '.$county_name.' '.$town_name.' '.$address;

        $out_warehouse->order_id = $out_warehouse->order ? $out_warehouse->order->id : '';
        $out_warehouse->order_department = config('constant.D3IN_department');
        $out_warehouse->num = $out_warehouse->order ? $out_warehouse->order->number : '';
        $out_warehouse->buyer_name = $out_warehouse->order ? $out_warehouse->order->buyer_name : '';
        $out_warehouse->buyer_phone = $out_warehouse->order ? $out_warehouse->order->buyer_phone : '';
        $out_warehouse->storage_id = $out_warehouse->storage ? $out_warehouse->storage->id : '';

        $out_warehouse->outWarehouse_sku = $out_warehouse->created_at;//出库单创建时间
        $out_warehouse->storage_name = $out_warehouse->storage->name;
        $out_warehouse->not_count = $out_warehouse->count - $out_warehouse->out_count;
        $out_sku = OutWarehouseSkuRelationModel::where('out_warehouse_id', $id)->get();

        $sku_model = new ProductsSkuModel();
        $out_skus = $sku_model->detailedSku($out_sku);
        foreach ($out_sku as $sku) {
            $sku->not_count = (int)($sku->count - $sku->out_count);
        }

        $logistics_list = $logistic_list = LogisticsModel::OfStatus(1)->select(['id', 'name'])->get();
        return view('home.storage.orderOutWarehouses', [
            'out_warehouse' => $out_warehouse,
            'out_skus' => $out_skus,
            'tab_menu' => $this->tab_menu,
            'logistics_list' => $logistics_list
        ]);

    }

    /**
     * 调拨出库单编辑出库明细展示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOutWare(Request $request, $id)
    {
        $out_warehouse = OutWarehousesModel::find($id);
        //判断是否审核通过
        if ($out_warehouse->status == 0) {
            return '尚未审核';
        }

        $out_warehouse->changeWarehouse_id = $out_warehouse->changeWarehouse ? $out_warehouse->changeWarehouse->id : '';
        $out_warehouse->changeWarehouse_department = $out_warehouse->changeWarehouse ? $out_warehouse->changeWarehouse->out_department : '';//调出部门
        $out_warehouse->storage_id = $out_warehouse->storage ? $out_warehouse->storage->id : '';

        $out_warehouse->storage_name = $out_warehouse->storage->name;
        $out_warehouse->not_count = $out_warehouse->count - $out_warehouse->out_count;
        $out_sku = OutWarehouseSkuRelationModel::where('out_warehouse_id', $id)->get();

        $sku_model = new ProductsSkuModel();
        $out_skus = $sku_model->detailedSku($out_sku);
        foreach ($out_sku as $sku) {
            $sku->not_count = (int)($sku->count - $sku->out_count);
        }

        // 如果是调拨出库单返回调拨入库的仓库地址信息
        $consignor = null;
        $change = null;
        if ($out_warehouse->type == 3) {
            $change = ChangeWarehouseModel::find($out_warehouse->target_id);
            $consignor = ConsignorModel::where(['storage_id' => $change->in_storage_id])->first();
        }

        return view('home.storage.changeWarehouseOut', [
            'out_warehouse' => $out_warehouse,
            'out_skus' => $out_skus,
            'consignor' => $consignor,
            'change' => $change,
            'tab_menu' => $this->tab_menu,
        ]);

    }

    /**
     * 获取出库单详细信息
     * @param Request $request
     * @return string
     */
    public function ajaxEdit(Request $request)
    {
        $out_warehouse_id = (int)$request->input('out_warehouse_id');
        if (empty($out_warehouse_id)) {
            return ajax_json(0, '参数错误');
        }
        $out_warehouse = OutWarehousesModel::find($out_warehouse_id);
        if (!$out_warehouse) {
            return ajax_json(0, '参数错误');
        }

        //判断是否审核通过
        if ($out_warehouse->status == 0) {
            return ajax_json(0, '尚未审核');
        }

        $out_warehouse->storage_name = $out_warehouse->storage->name;
        $out_warehouse->not_count = $out_warehouse->count - $out_warehouse->out_count;
        $out_sku = OutWarehouseSkuRelationModel::where('out_warehouse_id', $out_warehouse_id)->get();
        if (!$out_sku) {
            return ajax_json(0, '参数错误');
        }
        $sku_model = new ProductsSkuModel();
        $out_sku = $sku_model->detailedSku($out_sku);
        foreach ($out_sku as $sku) {
            $sku->not_count = (int)($sku->count - $sku->out_count);
        }

        // 如果是调拨出库单返回调拨入库的仓库地址信息
        $consignor = null;
        $change = null;
        if ($out_warehouse->type == 3) {
            $change = ChangeWarehouseModel::find($out_warehouse->target_id);
            $consignor = ConsignorModel::where(['storage_id' => $change->in_storage_id])->first();
        }

        $data = ['out_warehouse' => $out_warehouse, 'out_sku' => $out_sku, 'consignor' => $consignor, 'change' => $change];
        return ajax_json(1, 'ok', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OutWarehouseRequest $request)
    {
        $out_warehouse_id = (int)$request->input('out_warehouse_id');
        $summary = $request->input('summary');
        $storage_id = $request->input('storage_id');
        $changeWarehouse_id = $request->input('changeWarehouse_id','');
        $changeWarehouse_department = $request->input('changeWarehouse_department','');

        $order_department = $request->input('order_department','');
        $order_id = $request->input('order_id','');
        //获取快递公司ID  快递单号
        $logistics_id = $request->input('logistics_id','');
        $logistics_no = $request->input('logistics_no','');

        $out_sku_id_arr = $request->input('out_sku_id');
        $sku_id_arr = $request->input('sku_id');
        $count_arr = $request->input('count');
        $sum = 0;
        foreach ($count_arr as $count) {
            $sum = $sum + $count;
        }
        $out_warehouse_model = OutWarehousesModel::find($out_warehouse_id);
        if ($out_warehouse_model) {
            if ($sum > ($out_warehouse_model->count - $out_warehouse_model->out_count)) {
                return view('errors.503');
            }
            $out_warehouse_model->out_count = $out_warehouse_model->out_count + $sum;
            $out_warehouse_model->summary = $summary;

            DB::beginTransaction();
            if ($out_warehouse_model->save()) {
                $sku_arr = [];
                for ($i = 0; $i < count($out_sku_id_arr); $i++) {
                    if ($out_sku = OutWarehouseSkuRelationModel::find($out_sku_id_arr[$i])) {

                        if ($count_arr[$i] > $out_sku->count - $out_sku->out_count) {
                            DB::roolBack();
                            return view('errors.503');
                        }

                        $out_sku->out_count = $out_sku->out_count + $count_arr[$i];
                        if (!$out_sku->save()) {
                            DB::roolBack();
                            return view('errors.503');
                        }

                        //减少商品/SKU 总库存
                        $skuModel = new ProductsSkuModel();
                        if (!$skuModel->reduceInventory($sku_id_arr[$i], $count_arr[$i])) {
                            DB::roolBack();
                            return view('errors.503');
                        }

                        //如果为订单出库，修改付款占货
                        if ($out_warehouse_model->type == 2) {
                            if (!$skuModel->decreasePayCount($sku_id_arr[$i], $count_arr[$i])) {
                                DB::rollBack();
                                Log::error('订单发货修改付款占货比错误');
                                return view('errors.503');
                            }
                        }

                        $sku_arr[$sku_id_arr[$i]] = $count_arr[$i];

                        if ($out_warehouse_model->type == 2){//订单出库
                            $order_out = new OrderOutModel();
                            $order_out->user_id = Auth::user()->id;
                            $order_out->sku_id = $sku_id_arr[$i];
                            $order_out->order_id = $order_id;
                            $order_out->storage_id = $storage_id;
                            $order_out->department = $order_department;
                            $order_out->number = $count_arr[$i];
                            $order_out->outage_time = date("Y-m-d H:i:s");
                            if (!$order_out->save()) {
                                DB::rollBack();
                                return view('errors.503');
                            }
                            $this->ajaxSendOut($request);
                        }
                        }elseif ($out_warehouse_model->type == 3){//调拨出库
                        $allocation_out = new AllocationOutModel();
                        $allocation_out->user_id = Auth::user()->id;
                        $allocation_out->sku_id = $sku_id_arr[$i];
                        $allocation_out->storage_id = $storage_id;
                        $allocation_out->allocation_id = $changeWarehouse_id;
                        $allocation_out->number = $count_arr[$i];
                        $allocation_out->department = $changeWarehouse_department;
                        $allocation_out->type = 2;
                        $allocation_out->outorin_time = date("Y-m-d H:i:s");
                        if (!$allocation_out->save()) {
                            DB::rollBack();
                            return view('errors.503');
                        }

                    } else {
                        DB::roolBack();
                        return view('errors.503');
                    }
                }

                //修改出库单出库状态;相关单据出库数量,出库状态,明细出库数量
                if (!$out_warehouse_model->setStorageStatus($sku_arr)) {
                    DB::roolBack();
                    return view('errors.503');
                }

                //减少对应仓库/部门 SKU库存
                $storage_id = $out_warehouse_model->storage_id;
                $department = $out_warehouse_model->department;
                $storage_sku_count = new StorageSkuCountModel();
                if (!$storage_sku_count->out($storage_id, $department, $sku_arr)) {
                    DB::roolBack();
                    return view('errors.503');
                }

                DB::commit();
                return redirect('/outWarehouse/orderOut');
//                return back()->withInput();
            } else {
                DB::roolBack();
                return view('errors.503');
            }
        }
    }

    // 仓库订单发货处理 -- 2018年09月13日16:19:02
    public function ajaxSendOut(Request $request)
    {
        try {
            $order_id = (int)$request->input('order_id');
            $order_model = OrderModel::find($order_id);

            // 1、验证订单状态，仅待发货订单，才继续
            if ($order_model->status != 8 || $order_model->suspend == 1) {
                return ajax_json(0, 'error', '该订单不是待发货订单');
            }

            DB::beginTransaction();

            $order_model->send_user_id = Auth::user()->id;
            $order_model->order_send_time = date("Y-m-d H:i:s");

            if (!$order_model->changeStatus($order_id, 10)) {
                DB::rollBack();
                Log::error('Send Order ID:' . $order_id . '订单发货修改状态错误');
                return ajax_json(0, 'error', '订单发货修改状态错误');
            }


            //手动发货，获取快递公司ID  快递单号
            $logistics_id = $request->input('logistics_id');
            $logistics_no = $request->input('logistics_no');

            if ($LogisticsModel = LogisticsModel::find($logistics_id)) {
                $kdn_logistics_id = $LogisticsModel->kdn_logistics_id;
            } else {
                DB::rollBack();
                return ajax_json(0, 'error', '物流不存在');
            }

            $out_warehouse_id = (int)$request->input('out_warehouse_id');
            $out_warehouse_model = OutWarehousesModel::find($out_warehouse_id);
            if ($out_warehouse_model->storage_status == 5){
                $order_model->express_id = $logistics_id;

                //快递单号保存
                $order_model->express_no = $logistics_no;
                if (!$order_model->save()) {
                    DB::rollBack();
                    Log::error('ID:' . $order_id . '订单运单号保存失败');
                    return ajax_json(0, 'error', '订单运单号保存失败');
                }
            }
            $outgoing_logistics = new OutgoingLogisticsModel();
            $outgoing_logistics->order_id = $order_id;
            $outgoing_logistics->logistics_company = $logistics_id;
            $outgoing_logistics->odd_numbers = $logistics_no;
            if (!$outgoing_logistics->save()) {
                DB::rollBack();
                Log::error('ID:' . $order_id . '订单出库快递信息保存失败');
                return ajax_json(0, 'error', '订单出库快递信息保存失败');
            }

            //订阅订单物流
            $KdnOrderTracesSub = new KdnOrderTracesSub();
            $KdnOrderTracesSub->orderTracesSubByJson($kdn_logistics_id, $logistics_no, $order_id);


            // 编辑出库处理
            $out_warehouse_model = OutWarehousesModel::query()->where(['target_id' => $order_id, 'type' => 2])->first();
            $out_warehouse_model->out_count = $out_warehouse_model->count;
            $out_warehouse_model->storage_status = 5;
            $out_warehouse_model->summary = '';
            if ($out_warehouse_model->save()) {
                $sku_arr = [];
                $out_sku_s = $out_warehouse_model->outWarehouseSkuRelation;
                foreach ($out_sku_s as $out_sku) {

                    $out_sku->out_count = $out_sku->count;
                    if (!$out_sku->save()) {
                        DB::roolBack();
                        return view('errors.503');
                    }

                    //减少商品/SKU 总库存
                    $skuModel = new ProductsSkuModel();
                    if (!$skuModel->reduceInventory($out_sku->sku_id, $out_sku->count)) {
                        DB::roolBack();
                        return view('errors.503');
                    }

                    //如果为订单出库，修改付款占货
                    if ($out_warehouse_model->type == 2) {
                        if (!$skuModel->decreasePayCount($out_sku->sku_id, $out_sku->count)) {
                            DB::rollBack();
                            Log::error('订单发货修改付款占货比错误');
                            return view('errors.503');
                        }
                    }

                    $sku_arr[$out_sku->sku_id] = $out_sku->count;
                }


                //减少对应仓库/部门 SKU库存
                $storage_id = $out_warehouse_model->storage_id;
                $department = $out_warehouse_model->department;
                $storage_sku_count = new StorageSkuCountModel();
                if (!$storage_sku_count->out($storage_id, $department, $sku_arr)) {
                    DB::roolBack();
                    return view('errors.503');
                }

            } else {
                DB::roolBack();
                return view('errors.503');
            }

            DB::commit();

            return ajax_json(1, 'ok');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
        }

    }

    /*
     * 完成出库搜索
     *
     */
    public
    function search(Request $request)
    {
        $where = $request->input('where');
        $out_warehouses = OutWarehousesModel::where('number', 'like', '%' . $where . '%')->paginate(20);
        foreach ($out_warehouses as $out_warehouse) {
            switch ($out_warehouse->type) {
                case 1:
                    if ($out_warehouse->returnedPurchase) {
                        $out_warehouse->returned_number = $out_warehouse->returnedPurchase->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                case 2:
                    if ($out_warehouse->order) {
                        $out_warehouse->returned_number = $out_warehouse->order->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                case 3:
                    if ($out_warehouse->changeWarehouse) {
                        $out_warehouse->returned_number = $out_warehouse->changeWarehouse->number;
                    } else {
                        $out_warehouse->returned_number = '';
                    }
                    break;
                default:
                    return view('errors.503');
            }
            $out_warehouse->storage_name = $out_warehouse->storage->name;
            if ($out_warehouse->user) {
                $out_warehouse->user_name = $out_warehouse->user->realname;
            } else {
                $out_warehouse->user_name = '';
            }

        }
        if ($out_warehouses) {
            return view('home/storage.returnedOutWarehouse', [
                'out_warehouses' => $out_warehouses,
                'tab_menu' => $this->tab_menu,
                'where' => $where
            ]);
        }


    }

//采购退货货单出库审核
    public
    function verifyReturned(Request $request)
    {
        $id = (int)$request->input('id');
        if (!$model = OutWarehousesModel::find($id)) {
            return ajax_json(0, '参数错误');
        }

        //判断出库单类型是否未采购单出库 型：1. 采购退货；2.订单；3.调拔
        if ($model->type != 1) {
            return ajax_json(0, '类型错误');
        }

        //更改审核状态
        if (!$model->verify()) {
            return ajax_json(0, '内部错误');
        }

        return ajax_json(1, 'ok');
    }

//订单出库审核
    public
    function verifyOrder(Request $request)
    {
        $id = (int)$request->input('id');
        if (!$model = OutWarehousesModel::find($id)) {
            return ajax_json(0, '参数错误');
        }

        //判断出库单类型是否未订单出库 型：1. 采购退货；2.订单；3.调拔
        if ($model->type != 2) {
            return ajax_json(0, '类型错误');
        }

        //更改审核状态
        if (!$model->verify()) {
            return ajax_json(0, '内部错误');
        }

        return ajax_json(1, '审核成功');
    }

//调拨库存审核
    public
    function verifyChange(Request $request)
    {
        $id = (int)$request->input('id');
        if (!$model = OutWarehousesModel::find($id)) {
            return ajax_json(0, '参数错误');
        }

        //判断出库单类型是否调拨出库出库 型：1. 采购退货；2.订单；3.调拔
        if ($model->type != 3) {
            return ajax_json(0, '类型错误');
        }

        //更改审核状态
        if (!$model->verify()) {
            return ajax_json(0, '内部错误');
        }

        return ajax_json(1, 'ok');
    }

    /**
     * 删除出库单
     *
     * @param Request $request
     * @return string
     */
    public
    function ajaxDelete(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return ajax_json(0, 'error');
        }
        $id = $request->input('id');
        if (empty($id)) {
            return ajax_json(0, '参数为空');
        }
        $out_order = OutWarehousesModel::find($id);
        $out_order->deleteOutWarehouse();
        return ajax_json(1, 'ok');
    }

}
