<?php
/**
 * 订单导入导出模版
 */

namespace App\Models;

use App\Models\BaseModel;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OrderMould extends BaseModel
{
    protected $table = 'order_moulds';

    protected $fillable = ['name', 'user_id', 'type', 'kind', 'status', 'summary', 'outside_target_id', 'sku_number', 'sku_count', 'buyer_name', 'buyer_tel', 'buyer_phone', 'buyer_zip', 'buyer_province', 'buyer_city', 'buyer_county', 'buyer_township', 'buyer_address', 'buyer_summary', 'seller_summary', 'order_start_time', 'invoice_type', 'invoice_header', 'invoice_info', 'invoice_added_value_tax', 'invoice_ordinary_number', 'express_content', 'express_name', 'express_no', 'freight', 'discount_money', 'order_no', 'outside_sku_number', 'sku_name'];

    //相对关联用户表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }


    /**
     * 供应商模板列表
     *
     * @return mixed
     */
    public static function mouldList()
    {
        return OrderMould::where(['type' => 2, 'status' => 1])->get();
    }


    /**
     * 获取模板设置信息 返回排好序的数组或null
     *
     * @param $id integer 模板ID
     * @return array|null
     */
    public static function mouldInfo($id)
    {
        $order_mould = OrderMould::select(
            ['outside_target_id', 'order_no', 'summary', 'buyer_summary', 'seller_summary', 'order_start_time', 'outside_sku_number', 'sku_number', 'sku_count', 'sku_name', 'buyer_name', 'buyer_tel', 'buyer_phone', 'buyer_zip', 'buyer_province', 'buyer_city', 'buyer_county', 'buyer_township', 'buyer_address', 'invoice_type', 'invoice_info', 'invoice_header', 'invoice_added_value_tax', 'invoice_ordinary_number', 'express_content', 'express_no', 'express_name', 'freight', 'discount_money']
        )->where('id', '=', $id)->first();
        if (!$order_mould) {
            return null;
        }

        $data = $order_mould->toArray();
        $data = array_filter($data, function ($v) {
            if (empty($v)) {
                return false;
            } else {
                return true;
            }
        });

        asort($data, SORT_NUMERIC);

        // 列次序
        $n = 1;
        // 空白列使用默认字段填充
        $new_data = [];
        // 默认空字段
        $default_blank_column = 'default_blank_column';

        // 补充缺少的列
        foreach($data as $k => $v){
            # 使用默认字段补充缺少的列
            if($v > $n){
                while(true){
                    $new_data[$default_blank_column] = $n++;
                    if($v == $n){
                        break;
                    }
                }
            }

            $new_data[$k] = $v;
            $n++;
        }

        return $new_data;
    }


    /**
     * 订单导出，匹配模板查询sql拼接
     *
     * @param array $order_mould_data
     * @return string
     * @throws \Exception
     */
    public static function orderOutSelectSql(array $order_mould_data)
    {
        # 导入导出模板对应表字段数组
        $tmp_data = [
            'default_blank_column' => 'null as 空',  # 默认为空的列
            'outside_target_id' => 'order.outside_target_id as 站外订单号',
            'order_no' => 'order.number as 订单号',
            'summary' => 'order.summary as 备注',
            'buyer_summary' => 'order.buyer_summary as 买家备注',
            'seller_summary' => 'order.seller_summary as 卖家备注',
            'order_start_time' => 'order.order_start_time as 下单时间',
            'outside_sku_number' => 'products_sku.unique_number as 站外sku编码',
            'sku_number' => 'order_sku_relation.sku_number as sku编码',
            'sku_count' => 'order_sku_relation.quantity as 数量',
            'sku_name' => 'order_sku_relation.sku_name as sku名称',
            'buyer_name' => 'order.buyer_name as 买家姓名',
            'buyer_tel' => 'order.buyer_tel as 电话',
            'buyer_phone' => 'order.buyer_phone as 手机',
            'buyer_zip' => 'order.buyer_zip as 邮编',
            'buyer_province' => 'order.buyer_province as 省份',
            'buyer_city' => 'order.buyer_city as 城市',
            'buyer_county' => 'order.buyer_county as 区县',
            'buyer_township' => 'order.buyer_township as 乡镇',
            'buyer_address' => 'order.buyer_address as 地址',
            'invoice_type' => 'order.invoice_type as 发票类型',
            'invoice_info' => 'order.invoice_info as 发票内容',
            'invoice_header' => 'order.invoice_header as 发票抬头',
            'invoice_added_value_tax' => 'order.invoice_added_value_tax as 增值税发票',
            'invoice_ordinary_number' => 'order.invoice_ordinary_number as 普通发票号',
            'express_content' => 'order.express_content as 物流信息',
            'express_no' => 'order.express_no as 运单号',
            'express_name' => 'logistics.name as 物流',
            'freight' => 'order.freight as 运费',
            'discount_money' => 'order.discount_money as 优惠金额',
        ];

        $sql_data = [];
        foreach ($order_mould_data as $k => $v)
        {
            if(!array_key_exists($k, $tmp_data)){
                throw new \Exception('导出模板字段不存在');
            }
            $sql_data[] = $tmp_data[$k];
        }

        return implode(',', $sql_data);
    }


    static public function mould($data ,$user_id ,$mime ,$file_records_id , $mould_id , $distributor_id)
    {

        $orderMould = OrderMould::where('id', $mould_id)->first();
        $outside_target_id = $orderMould->outside_target_id;
        $sku_number = $orderMould->sku_number;
        $buyer_name = $orderMould->buyer_name;
        $buyer_phone = $orderMould->buyer_phone;
        $buyer_address = $orderMould->buyer_address;
        $order_start_time = $orderMould->order_start_time;
        $summary = $orderMould->summary;
        $buyer_summary = $orderMould->buyer_summary;
        $seller_summary = $orderMould->seller_summary;
        $sku_count = $orderMould->sku_count;
        $buyer_tel = $orderMould->buyer_tel;
        $buyer_zip = $orderMould->buyer_zip;
        $buyer_province = $orderMould->buyer_province;
        $buyer_city = $orderMould->buyer_city;
        $buyer_county = $orderMould->buyer_county;
        $buyer_township = $orderMould->buyer_township;
        $express_name = $orderMould->express_name;
        $express_no = $orderMould->express_no;
        $express_content = $orderMould->express_content;
        $invoice_type = $orderMould->invoice_type;
        $invoice_header = $orderMould->invoice_header;
        $invoice_info = $orderMould->invoice_info;
        $invoice_added_value_tax = $orderMould->invoice_added_value_tax;
        $invoice_ordinary_number = $orderMould->invoice_ordinary_number;
        $freight = $orderMould->freight;
        $discount_money = $orderMould->discount_money;

        $name = uniqid();
        $file = config('app.tmp_path') . $name . '.' . $mime;
        $current = file_get_contents($data, true);

        $files = file_put_contents($file, $current);
        $results = Excel::load($file, function ($reader) {
        })->get();

        $results = $results->toArray();
        //订单总条数
        $total_count = count($results);
        //成功的订单号
        $success_outside_target_id = [];
        //重复的订单号
        $repeat_outside_target_id = [];
        //不存在的sku
        $no_sku_number = [];
        //空字段的订单号
        $null_field = [];
        //商品库存不够的单号
        $sku_quantity = [];
        //备注
        $file_summary = '';

        foreach ($results as $d) {
            $new_data = [];
            foreach ($d as $v) {
                $new_data[] = $v;
            }

            $data = $new_data;
            if ($outside_target_id >= 1) {
                $outsideTargetId = $data[(int)$outside_target_id - 1];
                $outside_target = OrderModel::where('outside_target_id', $outsideTargetId)->first();
                //订单重复导入
                if ($outside_target) {
                    $repeat_outside_target_id[] = $data[(int)$outside_target_id - 1];
                    continue;
                }
            }
            if ($sku_count >= 1) {
                $skuCount = $data[(int)$sku_count - 1];
            } else {
                $skuCount = 1;
            }

            if($sku_number >= 1){
                //分销sku_number
                $skuNumber = $data[(int)$sku_number-1];
                //
                $skuDistributor = SkuDistributorModel::where('distributor_number' , $skuNumber)->first();
                //判断分销id
                if($distributor_id !== 0){
                    $distributorId = $distributor_id;
                }else{
                    $distributorId = $user_id;
                }

                if($skuDistributor){
                    $sku = ProductsSkuModel::where('number' , $skuDistributor->sku_number)->first();
                    $not_see_product_id_arr = UserProductModel::notSeeProductId($distributorId);
                    $product_id = $sku->product_id;
                    $products = ProductsModel::where('id' , $product_id)->where('saas_type' , 1)->whereNotIn('id', $not_see_product_id_arr)->get();
                }else{
                    $sku = ProductsSkuModel::where('number' , $skuNumber)->first();
                    $not_see_product_id_arr = UserProductModel::notSeeProductId($distributorId);
                    $product_id = $sku->product_id;
                    $products = ProductsModel::where('id' , $product_id)->where('saas_type' , 1)->whereNotIn('id', $not_see_product_id_arr)->get();

                }
                if($products->isEmpty()){
                    Log::info(22);
                    $file_summary = $data[(int)$outside_target_id - 1].',商品没有开放.';
                    continue;

                }
                //如果没有sku号码，存入到数组中
                if (!$sku) {
                    $no_sku_number[] = $data[(int)$outside_target_id - 1];
                    continue;
                }
                //增加 付款订单占货
                $productSku = new ProductsSkuModel();
                $productSku->increasePayCount($sku->id , $skuCount);
                $product_sku_id = $sku->id;

                //检查sku库存是否够用
                $product_sku_relation = new ProductSkuRelation();
                //分发saas sku信息详情
                $product_sku = $product_sku_relation->skuInfo($user_id , $product_sku_id);
                //saas sku库存减少
                $product_sku_quantity = $product_sku_relation->reduceSkuQuantity($product_sku_id , $user_id , $skuCount);
                if($product_sku_quantity[0] === false){
                    $sku_quantity[] = $data[(int)$outside_target_id-1];

                    continue;
                }
            }
            //姓名电话地址，有一个没写就返回记录
            if ($buyer_name < 1 || $buyer_phone < 1 || $buyer_address < 1) {
                $null_field[] = $data[(int)$outside_target_id - 1];
                continue;
            }

            $order = new OrderModel();
            $order->number = CountersModel::get_number('DD');
            $order->status = 5;
            $order->outside_target_id = $data[(int)$outside_target_id - 1];
            $order->payment_type = 1;
            $order->type = 6;
            $order->payment_type = 1;
            $order->buyer_name = $data[(int)$buyer_name - 1];
            $order->buyer_phone = $data[(int)$buyer_phone - 1];
            $order->buyer_address = $data[(int)$buyer_address - 1];
            $order->user_id = $user_id;
            if($distributor_id !== 0){
                $order->distributor_id = $distributor_id;
            }else{
                $order->distributor_id = $user_id;
            }
            $order->user_id_sales = config('constant.user_id_sales');
            $order->store_id = config('constant.store_id');
            //设置仓库id
            $storeStorageLogistics = StoreStorageLogisticModel::where('store_id' , config('constant.store_id'))->first();
            if($storeStorageLogistics){
                $order->storage_id = $storeStorageLogistics->storage_id;
                $order->express_id = $storeStorageLogistics->logistics_id;
            }
            $order->from_type = 2;
            $order->count = $skuCount;

            $order->total_money = $skuCount * $product_sku['price'];
            $order->order_start_time = $data[(int)$order_start_time-1] ? $data[(int)$order_start_time-1] : '0000-00-00 00:00:00';
            if($freight >=1){
                $order->freight = $data[(int)$freight-1];
            }
            if($discount_money >=1){
                $order->discount_money = $data[(int)$discount_money-1];
                $order->pay_money = ($skuCount * $product_sku['price']) - $data[(int)$discount_money-1];

            }else{
                $order->pay_money = $skuCount * $product_sku['price'];

            }
            if ($buyer_tel >= 1) {
                $order->buyer_tel = $data[(int)$buyer_tel - 1];
            }
            if ($buyer_zip >= 1) {
                $order->buyer_zip = $data[(int)$buyer_zip - 1];
            }
            if ($buyer_province >= 1) {
                $order->buyer_province = $data[(int)$buyer_province - 1];
            }
            if ($buyer_city >= 1) {
                $order->buyer_city = $data[(int)$buyer_city - 1];
            }
            if ($buyer_county >= 1) {
                $order->buyer_county = $data[(int)$buyer_county - 1];
            }
            if ($buyer_township >= 1) {
                $order->buyer_township = $data[(int)$buyer_township - 1];
            }
            if ($buyer_summary >= 1) {
                $order->buyer_summary = $data[(int)$buyer_summary - 1];
            }
            if ($seller_summary >= 1) {
                $order->seller_summary = $data[(int)$seller_summary - 1];
            }
            if ($summary >= 1) {
                $order->summary = $data[(int)$summary - 1];
            }
            if ($invoice_type >= 1) {
                $order->invoice_type = $data[(int)$invoice_type - 1];
            }
            if ($invoice_header >= 1) {
                $order->invoice_header = $data[(int)$invoice_header - 1];
            }
            if ($invoice_info >= 1) {
                $order->invoice_info = $data[(int)$invoice_info - 1];
            }
            if ($invoice_added_value_tax >= 1) {
                $order->invoice_added_value_tax = $data[(int)$invoice_added_value_tax - 1];
            }
            if ($invoice_ordinary_number >= 1) {
                $order->invoice_ordinary_number = $data[(int)$invoice_ordinary_number - 1];
            }
            if ($express_no >= 1) {
                $order->express_no = $data[(int)$express_no - 1];
            }
            if ($express_content >= 1) {
                $order->express_content = $data[(int)$express_content - 1];
            }
            if ($express_name >= 1) {
                $express_name = $data[(int)$express_name - 1];
                $logistics = LogisticsModel::where('name', $express_name)->first();
                $order->express_id = $logistics->id;
            }

            if ($order->save()) {
                //保存收款单
                $receiveOrder = new ReceiveOrderModel();
                $receiveOrder->amount = $order->pay_money;
                $receiveOrder->payment_user = $order->buyer_name;
                $receiveOrder->type = 6;
                $receiveOrder->status = 1;
                $receiveOrder->target_id = $order->id;
                $receiveOrder->user_id = $user_id;
                $number = CountersModel::get_number('SK');
                $receiveOrder->number = $number;
                $receiveOrder->save();

                //保存订单明细
                $order_sku = new OrderSkuRelationModel();
                $order_sku->order_id = $order->id;
                $order_sku->sku_number = $product_sku['number'];
                $order_sku->sku_id = $product_sku_id;
                $product = ProductsModel::where('id', $product_id)->first();
                $order_sku->product_id = $product_id;
                $order_sku->sku_name = $product->title . '--' . $product_sku['mode'];
                $order_sku->quantity = $skuCount;
                $order_sku->price = $product_sku['price'];
                if(!$order_sku->save()) {
                    echo '订单详情保存失败';
                }
            } else {
                echo '订单保存失败';

            }
            //成功导入的订单号
            $success_outside_target_id[] = $data[(int)$outside_target_id - 1];
        }

        //导入成功的站外订单号
        $success_outside = $success_outside_target_id;
        //成功导入的订单数
        $success_count = count($success_outside);
        //不存在sku编码的
        $no_sku = $no_sku_number;
        $no_sku_string = implode(',', $no_sku);
        //没有找到sku的订单数
        $no_sku_count = count($no_sku);

        //重复的订单号
        $repeat_outside = $repeat_outside_target_id;
        $repeat_outside_string = implode(',', $repeat_outside);
        //重复导入的订单数
        $repeat_outside_count = count($repeat_outside);

        //空字段的订单号
        $nullField = $null_field;
        $null_field_string = implode(',', $nullField);
        //空字段的数量
        $null_field_count = count($nullField);

        //sku库存不够的
        $sku_storage_quantity = $sku_quantity;
        $sku_storage_quantity_string = implode(',', $sku_storage_quantity);
        $sku_storage_quantity_count = count($sku_storage_quantity);

        $fileRecord = FileRecordsModel::where('id', $file_records_id)->first();
        $file_record['status'] = 1;
        $file_record['total_count'] = $total_count ? $total_count : 0;
        $file_record['success_count'] = $success_count ? $success_count : 0;
        $file_record['no_sku_count'] = $no_sku_count ? $no_sku_count : 0;
        $file_record['no_sku_string'] = $no_sku_string ? $no_sku_string : '';
        $file_record['repeat_outside_count'] = $repeat_outside_count ? $repeat_outside_count : 0;
        $file_record['repeat_outside_string'] = $repeat_outside_string ? $repeat_outside_string : '';
        $file_record['null_field_count'] = $null_field_count ? $null_field_count : 0;
        $file_record['null_field_string'] = $null_field_string ? $null_field_string : '';
        $file_record['sku_storage_quantity_count'] = $sku_storage_quantity_count ? $sku_storage_quantity_count : 0;
        $file_record['sku_storage_quantity_string'] = $sku_storage_quantity_string ? $sku_storage_quantity_string : '';
        $file_record['summary'] = $file_summary;
        $fileRecord->update($file_record);

        if ($fileRecord->success_count == 0 && $fileRecord->repeat_outside_count == 0 && $fileRecord->null_field_count == 0 && $fileRecord->sku_storage_quantity_count == 0) {
            $all_file['status'] = 2;
            $fileRecord->update($all_file);
        }
        unlink($file);
        return;

    }

}
