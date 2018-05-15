<?php

namespace App\Http\Controllers\Home;

use App\Models\ChangeWarehouseModel;
use App\Models\ConsignorModel;
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
            'where' => $where
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

        return view('home/storage.returnedOutWarehouse', [
            'out_warehouses' => $out_warehouses,
            'tab_menu' => $this->tab_menu,
            'where' => $where
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
                return back()->withInput();
            } else {
                DB::roolBack();
                return view('errors.503');
            }
        }
    }

    /*
     * 完成出库搜索
     *
     */
    public function search(Request $request)
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
    public function verifyReturned(Request $request)
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
    public function verifyOrder(Request $request)
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
    public function verifyChange(Request $request)
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
    public function ajaxDelete(Request $request)
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
