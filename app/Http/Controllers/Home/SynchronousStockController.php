<?php

namespace App\Http\Controllers\Home;

/**
 * 手动同步库存
 */

use App\Jobs\SynchronousStock;
use App\Models\ProductsSkuModel;
use App\Models\SynchronousStockRecordModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SynchronousStockController extends Controller
{
    public function home()
    {
        $lists = SynchronousStockRecordModel::orderBy('id','desc')->paginate(20);
        return view('home/synchronousStock.index',['lists' => $lists]);
    }
    
    //同步库存
    public function synchronous()
    {
        //判断是否有同步任务正在执行
        $synchronous_count = SynchronousStockRecordModel::where('status',1)->count();
        if($synchronous_count > 0){
            return ajax_json(0,'正在同步，请等待');
        }

        /*添加库存同步开始信息*/
        $model = new SynchronousStockRecordModel();
        $model->status = 1;
        $model->user_id = Auth::user()->id;
        $model->time = date("Y-m-d H:i:s");
        if(!$model->save()){
            return ajax_json(0,'同步失败，稍后再试');
        }

        /*计算需要同步的SKU数量*/
        $sku_list = ProductsSkuModel::select('id')->get();
        $sku_count = count($sku_list);

        //同步记录ID
        $sid = $model->id;
        
        //添加队列结束标记
        $mark = '';
        
        //添加队列任务
        for ($i = 0; $i < $sku_count; $i++){
            if($i == $sku_count-1){
                $mark = 'end';
            }
            $this->dispatch(new SynchronousStock($sku_list[$i]->id,$mark,$sid));
        }
        unset($sku_list);
        return ajax_json(1,'正在同步');
    }
}
