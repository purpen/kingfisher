<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ProductsSkuModel;
use App\Models\StorageModel;
use App\Models\StorageSkuCountModel;
use App\Models\TakeStock;
use App\Models\TakeStockDetailed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TakeStockController extends Controller
{
    /**
     * 仓库盘点记录页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $storages = StorageModel::orderBy('id', 'desc')->get();

        $per_page = $request->input('per_page', $this->per_page);
        $take_stock = TakeStock::orderBy('id', 'desc')->paginate($per_page);

        return view('home/storage.takeStock', [
            'storages' => $storages,
            'take_stock' => $take_stock
        ]);
    }

    /**
     * 创建仓库盘点
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createTakeStock(Request $request)
    {
        $storage_id = $request->input('storage_id');

        $data = StorageSkuCountModel::with(['ProductsSku', 'Products'])
            ->where('storage_id', $storage_id)
            ->get();

        if ($data->isEmpty()) {
            return redirect()->action('Home\TakeStockController@index');
        }

        try {
            DB::beginTransaction();

            $take_stock = new TakeStock();
            $take_stock->storage_id = $storage_id;
            $take_stock->status = 0;
            $take_stock->summary = '';
            $take_stock->log = '';
            $take_stock->user_id = Auth::user()->id;
            $take_stock->save();

            foreach ($data as $v) {
                $take_stock_detailed = new TakeStockDetailed();
                $take_stock_detailed->take_stock_id = $take_stock->id;
                $take_stock_detailed->storage_sku_count_id = $v->id;
                $take_stock_detailed->department = $v->department_val;
                $take_stock_detailed->product_id = $v->product_id;
                $take_stock_detailed->product_number = $v->product_number;
                $take_stock_detailed->sku_id = $v->sku_id;
                $take_stock_detailed->sku_number = $v->ProductsSku->number;
                $take_stock_detailed->name = $v->Products->title;
                $take_stock_detailed->mode = $v->ProductsSku->mode;
                $take_stock_detailed->number = $v->count;
                $take_stock_detailed->storage_number = $v->count;
                $take_stock_detailed->save();

            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }

        return redirect()->action('Home\TakeStockController@index');
    }

    /**
     * 获取备注信息
     *
     * @param Request $request
     * @return string
     */
//    public function ajaxEdit(Request $request)
//    {
//        $id = $request->input('id');
//
//        if(!$take_stock = TakeStock::find($id)){
//            return ajax_json(0, 'not found');
//        }
//
//        return ajax_json(1,'',['summary' => $take_stock->summary]);
//    }

    /**
     * 添加盘点备注
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSummary(Request $request)
    {
        $id = $request->input('id');
        if (!$take_stork = TakeStock::find($id)) {
            return redirect()->action('Home\TakeStockController@index');
        }

        $take_stork->summary = $request->input('summary', '');
        $take_stork->save();

        return back()->withInput();
    }

//    确认盘点完成
    public function ajaxTrue(Request $request)
    {
        $id = $request->input('id');
        if (!$take_stock = TakeStock::find($id)) {
            return ajax_json(0, 'not found');
        }

        if ($take_stock->status == 1) {
            ajax_json(1, 'ok');
        }

        $take_stock_detailed = TakeStockDetailed::where('take_stock_id', $id)->get();
        $log = '';
        try {
            DB::beginTransaction();
            foreach ($take_stock_detailed as $v) {
                if ($v->storage_number !== $v->number) {
                    if ($storage_sku_count = StorageSkuCountModel::find($v->storage_sku_count_id)) {
                        $storage_sku_count->count = $v->storage_number;
                        // 调整 同仓库部门sku库存
                        if (!$storage_sku_count->save()) {
                            throw new \Exception("调整同仓库部门sku库存失败");
                        }

                        // 调整 总库存和sku库存
                        $products_sku_model = new ProductsSkuModel();
                        if (!$products_sku_model->reduceInventory($v->sku_id, $v->number - $v->storage_number)) {
                            throw new \Exception("调整 总库存和sku库存失败");
                        }

                        $log = $log . '【部门:' . $v->department . ',sku:' . $v->sku_number . '库存' . $v->number . '调整为' . $v->storage_number . '】';
                    }
                }
            }

            $take_stock->log = $log;
            $take_stock->status = 1;
            if (!$take_stock->save()) {
                throw new \Exception("盘点日志保存失败");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('确认盘点库存:' . $e->getMessage());
            return ajax_json(0, $e->getMessage());
        }

        return ajax_json(1, 'ok');
    }

    /**
     * 删除盘点
     *
     * @param Request $request
     * @return string
     */
    public function ajaxDeleteTakeStock(Request $request)
    {
        $id = $request->input('id');
        if (!$take_stork = TakeStock::find($id)) {
            return ajax_json(0, 'not found');
        }

        if ($take_stork->status == 1) {
            return ajax_json(0, '该盘点已确认，不能删除');
        }

        $take_stork->delete();

        return ajax_json(1, 'ok');
    }


//    查看盘点详细信息
    public function takeStockDetailed(Request $request)
    {
        $id = $request->input('id');
        if (!$take_stock = TakeStock::where('id', $id)->count()) {
            return back()->withInput();
        }

        $take_stock_detailed = TakeStockDetailed::where('take_stock_id', $id)->paginate(100);

        return view('home/storage.takeStockDetailed', [
            'take_stock_detailed' => $take_stock_detailed,
        ]);

    }

//    设置sku实际库存
    public function ajaxSetSkuNumber(Request $request)
    {
        $id = $request->input('id');
        $storage_number = $request->input('storage_number');

        if (!$take_stock_detailed = TakeStockDetailed::find($id)) {
            return ajax_json(0, 'not found');
        }

        $take_stock = TakeStock::find($take_stock_detailed->take_stock_id);
        if (!$take_stock || $take_stock->status == 1) {
            return ajax_json(0, '盘点已完成，不可修改');
        }


        $take_stock_detailed->storage_number = $storage_number;
        $take_stock_detailed->save();

        return ajax_json(1, 'ok');
    }
}