<?php

namespace App\Http\Controllers\Home;


use App\Models\OrderMould;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderMouldController extends Controller
{
    /**
     * 初始化
     */
    public function __construct()
    {
        // 设置菜单状态
        View()->share('tab_menu', 'active');
    }   
    
    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->tab_menu = 'all';
        $this->per_page = $request->input('per_page', $this->per_page);
        $type = $request->input('type') ? (int)$request->input('type') : 0;
        $status = $request->input('status') ? (int)$request->input('status') : 0;

        $query = array();
        if ($type) $query['type'] = $type;
        if ($status) {
            if ($status == -1) {
                $query['status'] = 0;
            } else {
                $query['status'] = 1;
            }
        }

        $orderMoulds = OrderMould::where($query)->orderBy('id', 'desc')->paginate(20);

        return view('home/orderMould.list', [
            'orderMoulds' => $orderMoulds,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $orderMould = new OrderMould();
        return view('home/orderMould.submit',['orderMould' => $orderMould]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $orderMould = OrderMould::find($id);
        return view('home/orderMould.submit',['orderMould' => $orderMould]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        $name = $request->input('name') ? $request->input('name') : null;
        $type = $request->input('type') ? (int)$request->input('type') : 0;
        $status = $request->input('status') ? (int)$request->input('status') : 0;

        $outside_target_id = $request->input('outside_target_id') ? (int)$request->input('outside_target_id') : 0;
        $summary = $request->input('summary') ? (int)$request->input('summary') : 0;
        $buyer_summary = $request->input('buyer_summary') ? (int)$request->input('buyer_summary') : 0;
        $seller_summary = $request->input('seller_summary') ? (int)$request->input('seller_summary') : 0;
        $order_start_time = $request->input('order_start_time') ? (int)$request->input('order_start_time') : 0;

        $sku_number = $request->input('sku_number') ? (int)$request->input('sku_number') : 0;
        $sku_count = $request->input('sku_count') ? (int)$request->input('sku_count') : 0;

        $buyer_name = $request->input('buyer_name') ? (int)$request->input('buyer_name') : 0;
        $buyer_tel = $request->input('buyer_tel') ? (int)$request->input('buyer_tel') : 0;
        $buyer_phone = $request->input('buyer_phone') ? (int)$request->input('buyer_phone') : 0;
        $buyer_zip = $request->input('buyer_zip') ? (int)$request->input('buyer_zip') : 0;
        $buyer_province = $request->input('buyer_province') ? (int)$request->input('buyer_province') : 0;
        $buyer_city = $request->input('buyer_city') ? (int)$request->input('buyer_city') : 0;
        $buyer_county = $request->input('buyer_county') ? (int)$request->input('buyer_county') : 0;
        $buyer_township = $request->input('buyer_township') ? (int)$request->input('buyer_township') : 0;
        $buyer_address = $request->input('buyer_address') ? (int)$request->input('buyer_address') : 0;
        
        $invoice_type = $request->input('invoice_type') ? (int)$request->input('invoice_type') : 0;
        $invoice_header = $request->input('invoice_header') ? (int)$request->input('invoice_header') : 0;
        $invoice_info = $request->input('invoice_info') ? (int)$request->input('invoice_info') : 0;
        $invoice_added_value_tax = $request->input('invoice_added_value_tax') ? (int)$request->input('invoice_added_value_tax') : 0;
        $invoice_ordinary_number = $request->input('invoice_ordinary_number') ? (int)$request->input('invoice_ordinary_number') : 0;

        $express_content = $request->input('express_content') ? (int)$request->input('express_content') : 0;
        $express_name = $request->input('express_name') ? (int)$request->input('express_name') : 0;
        $express_no = $request->input('express_no') ? (int)$request->input('express_no') : 0;

        $freight = $request->input('freight') ? (int)$request->input('freight') : 0;
        $discount_money = $request->input('discount_money') ? (int)$request->input('discount_money') : 0;

        if (empty($name) || empty($type) || empty($outside_target_id) || empty($sku_number) || empty($buyer_name) || empty($buyer_phone) || empty($buyer_address)) {
            return ajax_json(0, '缺少请求参数！');
        }
        try{
            $row = array(
                'name' => $name,
                'type' => $type,
                'status' => $status,

                'outside_target_id' => $outside_target_id,
                'summary' => $summary,
                'buyer_summary' => $buyer_summary,
                'seller_summary' => $seller_summary,
                'order_start_time' => $order_start_time,

                'sku_number' => $sku_number,
                'sku_count' => $sku_count,

                'buyer_name' => $buyer_name,
                'buyer_tel' => $buyer_tel,
                'buyer_phone' => $buyer_phone,
                'buyer_zip' => $buyer_zip,
                'buyer_province' => $buyer_province,
                'buyer_city' => $buyer_city,
                'buyer_county' => $buyer_county,
                'buyer_township' => $buyer_township,
                'buyer_address' => $buyer_address,

                'invoice_type' => $invoice_type,
                'invoice_header' => $invoice_header,
                'invoice_info' => $invoice_info,
                'invoice_added_value_tax' => $invoice_added_value_tax,
                'invoice_ordinary_number' => $invoice_ordinary_number,

                'express_content' => $express_content,
                'express_name' => $express_name,
                'express_no' => $express_no,

                'freight' => $freight,
                'discount_money' => $discount_money,
            );

            if (empty($id)) {
                $row['user_id'] = Auth::user()->id;
                $orderMould = orderMould::create($row);
            } else {
                $orderMould = orderMould::find($id);
                if ($orderMould) {
                    $orderMould = $orderMould->update($row);
                }
            }

            if($orderMould){
                // return ajax_json(1, 'success', $orderMould);
                return redirect('/orderMould');
            }else{
                return ajax_json(0, '数据不存在');
            }
        }
        catch (\Exception $e){
            Log::error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleted(Request $request)
    {
        // 再次判断ID是否为空
        $res = OrderMould::where('id','=',$request->input('id'))->delete();
        if($res){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
    }

}
