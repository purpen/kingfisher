<?php

namespace App\Console\Commands;


use App\Models\EnterWarehouseSkuRelationModel;
use App\Models\EnterWarehousesModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class SyncEnterWarehouse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:enterWarehouse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更改采购入库的状态';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $enterWarehouses = EnterWarehousesModel::where('storage_status', '!=', 5)->where('type' , 1)->get();

        foreach ($enterWarehouses as $enterWarehouse){
            $enter_warehouse_id = $enterWarehouse->id;

            $summary = '批量采购导入的sku';

            // 查询入库单信息
            $enter_warehouse_model = EnterWarehousesModel::find($enter_warehouse_id);
            if (!$enter_warehouse_model) {
                return;
            }
            $enter_warehouse_model->in_count = $enter_warehouse_model->count;
            $enter_warehouse_model->summary = $summary;

            if($enter_warehouse_model->save()){
                $enter_sku = EnterWarehouseSkuRelationModel::where('enter_warehouse_id' , $enterWarehouse->id)->first();
                if(!$enter_sku){
                    return;
                }
                $enter_sku->in_count = $enterWarehouse->count;
                if(!$enter_sku->save()){
                    return;
                }
                // 增加商品，SKU 总库存
                $skuModel = new ProductsSkuModel();
                if(!$skuModel->addInventory($enter_sku->sku_id,$enterWarehouse->count)){
                    return;
                }
                $sku_id = $enter_sku->sku_id;
                $count = $enterWarehouse->count;
                $sku_arr[$sku_id] = strval($count);
            }
            // 修改入库单入库状态、相关单据入库数量、入库状态、明细入库数量
            if (!$enter_warehouse_model->setStorageStatus($sku_arr)) {
                return;
            }
            // 增加对应仓库/部门的SKU库存   （添加sku 部门类型 --2017.2.13）
            $storage_id = $enter_warehouse_model->storage_id;
            $department = $enter_warehouse_model->department;
            $storage_sku_count = new StorageSkuCountModel();
            if (!$storage_sku_count->enter($storage_id, $department, $sku_arr)) {
                return;
            }


        }
    }
}
