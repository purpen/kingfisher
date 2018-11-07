<?php

namespace App\Console\Commands;

use App\Models\EnterWarehousesModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bugChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bug:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'bug修复用后就删';

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

        $d = [
            'RKCG2018110200006',
        ];

        $it = [
            501,
        ];
        try {
            DB::beginTransaction();
            foreach ($d as $v) {
                $ew = EnterWarehousesModel::query()->where("number", $v)->first();
                if (!$ew) {
                    continue;
                }
                $p = $ew->purchase;
                $p->in_count = $p->count; // 减少对应采购单入库数量
                $p->save();

                $ps = $p->purchaseSku;
                foreach ($ps as $p1) {
                    $p1->in_count = $p1->count;  // 采购单明细
                    $p1->save();
                }

                $storage_id = $ew->storage_id;
                $ewhs = $ew->enterWarehouseSkus;
                foreach ($ewhs as $ewh) {
                    $sku_id = $ewh->sku_id;

                    $sscm = StorageSkuCountModel::query()
                        ->where("sku_id", $sku_id)
                        ->where("storage_id", $storage_id)
                        ->first();
                    if ($sscm) {  // 仓库sku
                        $sscm->count = $sscm->count - $ewh->in_count;
                        $sscm->save();
                    }

                    $sku = ProductsSkuModel::find($sku_id);
                    if ($sku) {
                        $sku->quantity = $sku->quantity - $ewh->in_count;  //sku
                        $sku->save();

                        $product = $sku->product;
                        $product->inventory = $product->inventory - $ewh->in_count; // product
                        $product->save();
                    }
                    $ewh->delete();
                }
                $ew->delete();
            }

            foreach ($it as $t) {
                $p = PurchaseModel::find($t);
                $p->in_count = $p->count; // 减少对应采购单入库数量
                $p->save();

                $storage_id = $p->storage_id;

                $ps = $p->purchaseSku;
                foreach ($ps as $p1) {
                    $p1->in_count = $p1->count;  // 采购单明细
                    $p1->save();

                    $sku_id = $p1->sku_id;
                    $sscm = StorageSkuCountModel::query()
                        ->where("sku_id", $sku_id)
                        ->where("storage_id", $storage_id)
                        ->first();
                    if ($sscm) {  // 仓库sku
                        $sscm->count = $sscm->count - $p1->count;
                        $sscm->save();
                    }

                    $sku = ProductsSkuModel::find($sku_id);
                    if ($sku) {
                        $sku->quantity = $sku->quantity - $p1->count;  //sku
                        $sku->save();

                        $product = $sku->product;
                        $product->inventory = $product->inventory - $p1->count; // product
                        $product->save();
                    }
                }


            }

            $p = PurchaseModel::find(511);

            $storage_id = $p->storage_id;

            $ps = $p->purchaseSku;
            foreach ($ps as $p1) {

                $sku_id = $p1->sku_id;
                $sscm = StorageSkuCountModel::query()
                    ->where("sku_id", $sku_id)
                    ->where("storage_id", $storage_id)
                    ->first();
                if ($sscm) {  // 仓库sku
                    $sscm->count = $sscm->count + $p1->count;
                    $sscm->save();
                }

                $sku = ProductsSkuModel::find($sku_id);
                if ($sku) {
                    $sku->quantity = $sku->quantity + $p1->count;  //sku
                    $sku->save();

                    $product = $sku->product;
                    $product->inventory = $product->inventory + $p1->count; // product
                    $product->save();
                }
            }


        } catch (\Exception $e) {
            DB::rollBack();
            $this->info($e->getCode() . $e->getMessage());
        }
        DB::commit();
        $this->info("ok");
    }

}
