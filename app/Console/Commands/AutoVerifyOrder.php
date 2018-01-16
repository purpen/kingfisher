<?php

namespace App\Console\Commands;

use App\Models\OrderModel;
use App\Models\StorageSkuCountModel;
use App\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoVerifyOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动审核订单';

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
        $init_id = 0;
        while(true){
            $orders = OrderModel::where('status', '=', '5')
                ->where('suspend','=','0')
                ->where('id','>', $init_id)
                ->take(200)->get();
            if($orders->isEmpty()){
                break;
            }

            foreach ($orders as $order){
                $this->verify($order);

                $init_id = $order->id;
            }

        }
    }

    protected function verify($order)
    {
        $order_model = $order;
        if ($order_model->status != 5 || $order_model->suspend == 1) {
            return false;
//            return ajax_json(0,'该订单不属待审核状态');
        }

        # 判断仓库库存是否满足订单
        $order_sku = $order_model->orderSkuRelation;
        $storage_id = $order_model->storage_id;
        $sku_id_arr = [];
        $sku_count_arr = [];
        foreach ($order_sku as $sku) {
            $sku_id_arr[] = $sku->sku_id;
            $sku_count_arr[] = $sku->quantity;
        }

        if (empty($order_model->user_id_sales)) {
            return false;
//            return ajax_json(0,'参数错误，not department');
        }
        $department = UserModel::find($order_model->user_id_sales) ? UserModel::find($order_model->user_id_sales)->department : '';
        $storage_sku = new StorageSkuCountModel();
        if (!$storage_sku->isCount($storage_id, $department, $sku_id_arr, $sku_count_arr)) {
            return false;
//            return ajax_json(0,'发货商品所选仓库/部门库存不足');
        }

        DB::beginTransaction();
        $order_model->verified_user_id = 0; # 系统自动审核
        $order_model->order_verified_time = date("Y-m-d H:i:s");

        if (!$order_model->save()) {
            DB::rollBack();
            return false;
//            return ajax_json(0,'内部错误');
        }

        if (!$order_model->changeStatus($order_model, 8)) {
            DB::rollBack();
            return false;
//            return ajax_json(0,'审核失败');
        }

        if (!$order_model->daifaSplit($order_model)) {
            DB::rollBack();
            return false;
//            return ajax_json(0,'代发拆单失败');
        }

        DB::commit();

        return true;
    }
}
