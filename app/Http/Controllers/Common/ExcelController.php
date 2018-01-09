<?php

namespace App\Http\Controllers\Common;

use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\OrderMould;
use App\Models\OrderSkuRelationModel;
use App\Models\PaymentAccountModel;
use App\Models\PaymentOrderModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\purchasesInterimModel;
use App\Models\receiveOrderInterimModel;
use App\Models\ReceiveOrderModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * 使用订单ID 导出订单（excel格式）
     */
    public function orderList(Request $request)
    {
        //需要下载的订单 id数组
        $all = $request->all();
        $id_array = [];
        foreach ($all as $k => $v) {
            if (is_int($k)) {
                $id_array[] = $v;
            }
        }

        //查询订单数据集合
        $data = $this->orderSelect()->whereIn('id', $id_array)->get();

        //构造数据
        $data = $this->createData($data);

        //导出Excel表单
        $this->createExcel($data, '订单');
    }

    /**
     * 导出订单查询条件
     */
    public function orderSelect()
    {
        $orderObj = OrderModel::select([
            'number as 订单编号',
            'order_start_time as 下单时间',
            'count as 商品数量',
            'pay_money as 付款金额',
            'freight as 邮费',
            'id',
            'buyer_name as 买家名',
            'buyer_address as 收货地址',
            'buyer_summary as 买家备注',
            'store_id',
            'express_id',
            'express_no as 快递单号',
        ]);

        return $orderObj;
    }

    /**
     * 根据查询的数据对象 构造Excel数据
     *
     * @param OrderModel $option 查询where条件
     */
    protected function createData($data)
    {
        //组织Excel数据
        foreach ($data as $v) {
            if ($v->logistics) {
                $v->物流 = $v->logistics->name;
            } else {
                $v->物流 = '';
            }

            if ($v->store) {
                $v->店铺名称 = $v->store->name;
            } else {
                $v->店铺名称 = '';
            }

            //拼接订单详情内容
            $sku_info = '';
            foreach ($v->orderSkuRelation as $s) {
                $sku_info = $sku_info . $s->sku_name . '*' . $s->quantity . ';';
            }
            $v->明细 = $sku_info;

            unset($v->store_id, $v->express_id, $v->id, $v->change_status);

        }

        return $data;
    }

    /**
     * 生成导出的excel表单
     * @param $data 数据
     * @param string $message 名称
     */
    protected function createExcel($data, $message = '表单')
    {
        $message = strval($message);
        //生成excel表单
        Excel::create($message, function ($excel) use ($data) {
            $excel->sheet('1', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }


    /**
     * 导入订单Excel文件
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|string
     */
    public function inFile(Request $request)
    {
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return '上传失败';
        }
        $file = $request->file('file');

        //读取execl文件
        $results = Excel::load($file, function ($reader) {
        })->get();

        $results = $results->toArray();

        DB::beginTransaction();
        foreach ($results as $data) {
            $result = OrderModel::inOrder($data);
            if (!$result[0]) {
                DB::rollBack();
                return view('errors.200', ['message' => $result[1], 'back_url' => '/order']);
            }
        }
        DB::commit();

        return redirect('/order');
    }


    /**
     * 付款单列表查询条件
     */
    protected function paymentSelect()
    {
        $paymentObj = PaymentOrderModel
            ::select(['receive_user as 收款人', 'amount as 付款金额', 'payment_account_id', 'payment_time as 付款时间', 'type', 'summary as 备注']);
        return $paymentObj;
    }

    /**
     * 构造付款单execl数据
     */
    protected function createPaymentData($data)
    {
        foreach ($data as $v) {
            if ($v->payment_account_id) {
                $payAcc = PaymentAccountModel::find($v->payment_account_id);
                if ($payAcc) {
                    $v->付款账号 = $payAcc->account . ':' . $payAcc->bank;
                }
            } else {
                $v->付款账号 = '';
            }
            if ($v->type) {
                $v->类型 = $v->type_val;
            }
            unset($v->payment_account_id, $v->type);
        }

        return $data;
    }

    /**
     * 导出付款单（excel格式）
     *
     * @param Request $request
     */
    public function paymentList(Request $request)
    {
        //需要下载的付款单 id数组
        $all = $request->all();
        $id_array = [];
        foreach ($all as $k => $v) {
            if (is_int($k)) {
                $id_array[] = $v;
            }
        }

        //查询付款单数据集合
        $data = $this->paymentSelect()->whereIn('id', $id_array)->get();

        //构造数据
        $data = $this->createPaymentData($data);

        //导出Excel表单
        $this->createExcel($data, '付款单');
    }

    /**
     *按时间、类型导出付款单
     *
     * @param Request $request
     */
    public function dateGetPayment(Request $request)
    {
        $type = (int)$request->input('payment_type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $subnav = $request->input('subnav');

        $start_date = date("Y-m-d H:i:s", strtotime($start_date));
        $end_date = date("Y-m-d H:i:s", strtotime($end_date));

        if ($subnav === 'waitpay') {
            $status = 0;
        } else if ($subnav === 'finishpay') {
            $status = 1;
        }
        //查询付款单数据集合
        $query = $this->paymentSelect()->where('status', $status);
        if ($type) {
            $query->where('type', $type);
        }
        $data = $query->whereBetween('created_at', [$start_date, $end_date])->get();
        //构造数据
        $data = $this->createPaymentData($data);

        //导出Excel表单
        $this->createExcel($data, '付款单');
    }

    /**
     * 众筹导入Excel
     */
    public function zcInFile(Request $request)
    {
        $store_id = $request->input('store_id');
        $product_id = $request->input('product_id');
        $user_id = Auth::user()->id;
        Log::info($product_id);
        if (empty($store_id)) {
            return '店铺不能为空';

        }
        if (empty($product_id)) {
            return '商品不能为空';

        }
        $product = ProductsModel::where('id', $product_id)->first();
        $product_number = $product->number;
        if (!$request->hasFile('zcFile') || !$request->file('zcFile')->isValid()) {
            return '上传失败';
        }
        $file = $request->file('zcFile');

        //读取execl文件
        $results = Excel::load($file, function ($reader) {
        })->get();

        $results = $results->toArray();
        DB::beginTransaction();
        $new_data = [];

        foreach ($results as $data) {
            if (!empty($data['档位价格']) && !in_array($data['档位价格'], $new_data)) {
                $sku_number = 1;
                $sku_number .= date('ymd');
                $sku_number .= sprintf("%05d", rand(1, 99999));
                $product_sku = new ProductsSkuModel();
                $product_sku->product_id = $product_id;
                $product_sku->product_number = $product_number;
                $product_sku->number = $sku_number;
                $product_sku->price = $data['档位价格'];
                $product_sku->bid_price = $data['档位价格'];
                $product_sku->cost_price = $data['档位价格'];
                $product_sku->mode = '众筹款';
                $product_sku->save();
                $product_sku_id = $product_sku->id;
                $new_data[] = $product_sku->price;
            } else {
                $product_sku = ProductsSkuModel::where('price', $data['档位价格'])->where('mode', '众筹款')->first();
                $product_sku_id = $product_sku->id;
            }
            $result = OrderModel::zcInOrder($data, $store_id, $product_id, $product_sku_id, $user_id);
            if (!$result[0]) {
                DB::rollBack();
                return view('errors.200', ['message' => $result[1], 'back_url' => '/order']);
            }
        }
        DB::commit();

        return redirect('/order');
    }

    /**
     * 联系人excl
     */
    public function contactsInExcel(Request $request)
    {
        if (!$request->hasFile('contactsFile') || !$request->file('contactsFile')->isValid()) {
            return '上传失败';
        }
        $file = $request->file('contactsFile');

        //读取execl文件
        $results = Excel::load($file, function ($reader) {
        })->get();

        $results = $results->toArray();

        DB::beginTransaction();
        foreach ($results as $data) {
            $result = OrderModel::contactsInOrder($data);
            if (!$result[0]) {
                DB::rollBack();
                return view('errors.200', ['message' => $result[1], 'back_url' => '/order']);
            }
        }
        DB::commit();

        return redirect('/order');
    }

    /**
     * 收款单列表查询条件
     */
    protected function receiveSelect()
    {
        $receiveObj = receiveOrderInterimModel
            ::select([
                'department_name as 销售主体',
                'product_title as 销售产品',
                'supplier_name as 品牌',
                'order_type as 销售模式',
                'buyer_name as 客户名称',
                'order_start_time as 销售时间',
                'quantity as 销售数量',
                'price as 销售金额',
                'cost_price as 成本金额',
                'invoice_start_time as 开票时间',
                'total_money as 开票金额',
                'receive_time as 收款时间',
                'amount as 	收款金额',
            ]);
        return $receiveObj;
    }

    /**
     *按时间、类型导出收款单
     *
     */
    public function dateGetReceive(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $start_date = date("Y-m-d H:i:s", strtotime($start_date));
        $end_date = date("Y-m-d H:i:s", strtotime($end_date));

        //查询付款单数据集合
        $query = $this->receiveSelect();

        $data = $query->whereBetween('receive_time', [$start_date, $end_date])->get();
        //导出Excel表单
        $this->createExcel($data, '收入明细');
    }

    /**
     * 采购单列表查询条件
     */
    protected function purchasesSelect()
    {
        $purchasesObj = purchasesInterimModel
            ::select([
                'department_name as 采购主体',
                'product_title as 采购产品',
                'supplier_name as 供应商名称',
                'purchases_time as 采购时间',
                'quantity as 采购数量',
                'purchases_price as 采购金额',
                'invoice_start_time as 来票时间',
                'total_money as 来票金额',
                'payment_time as 付款时间',
                'payment_price as 	付款金额',

            ]);
        return $purchasesObj;
    }

    /**
     * 按时间导出采购单
     */
    public function dateGetPurchases(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start_date = date("Y-m-d H:i:s", strtotime($start_date));
        $end_date = date("Y-m-d H:i:s", strtotime($end_date));

        //查询付款单数据集合
        $query = $this->purchasesSelect();

        $data = $query->whereBetween('payment_time', [$start_date, $end_date])->get();

        //导出Excel表单
        $this->createExcel($data, '采购明细');
    }

    /**
     * 收入列表
     */
    public function receive()
    {
        $receiveOrder = receiveOrderInterimModel::orderBy('id', 'desc')->paginate(15);
        return view('home/receiveOrder.receiveOrder', [
            'receiveOrder' => $receiveOrder,
            'start_date' => '',
            'end_date' => '',
        ]);
    }

    /**
     * 收入搜索
     */
    public function receiveSearch(Request $request)
    {
        if ($request->isMethod('get')) {
            $time = $request->input('time') ? (int)$request->input('time') : 30;
            $start_date = date("Y-m-d H:i:s", strtotime("-" . $time . " day"));
            $end_date = date("Y-m-d H:i:s");
        }

        if ($request->isMethod('post')) {
            $start_date = date("Y-m-d H:i:s", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s", strtotime($request->input('end_date')));
        }

        //查询付款单数据集合
        $receiveOrder = receiveOrderInterimModel::whereBetween('receive_time', [$start_date, $end_date])->orderBy('id', 'desc')
            ->paginate(15);

        return view('home/receiveOrder.receiveOrder', [
            'receiveOrder' => $receiveOrder,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }


    /**
     * 采购列表
     */
    public function Purchases()
    {
        $purchases = purchasesInterimModel::orderBy('id', 'desc')->paginate(15);
        return view('home/purchase.purchasesInterim', [
            'purchases' => $purchases,
            'start_date' => '',
            'end_date' => '',
        ]);
    }

    /**
     * 采购搜索
     */
    public function PurchasesSearch(Request $request)
    {
        if ($request->isMethod('get')) {
            $time = $request->input('time') ? (int)$request->input('time') : 30;
            $start_date = date("Y-m-d H:i:s", strtotime("-" . $time . " day"));
            $end_date = date("Y-m-d H:i:s");
        }

        if ($request->isMethod('post')) {
            $start_date = date("Y-m-d H:i:s", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s", strtotime($request->input('end_date')));
        }

        //查询付款单数据集合
        $purchases = purchasesInterimModel::whereBetween('payment_time', [$start_date, $end_date])->orderBy('id', 'desc')
            ->paginate(15);

        return view('home/purchase.purchasesInterim', [
            'purchases' => $purchases,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }


    /**
     * 订单导入物流信息
     */
    public function logisticsInExcel(Request $request)
    {
        if (!$request->hasFile('logistics_file') || !$request->file('logistics_file')->isValid()) {
            return '上传失败';
        }
        $file = $request->file('logistics_file');

        //读取execl文件
        $results = Excel::load($file, function ($reader) {
        })->get();

        $results = $results->toArray();

        DB::beginTransaction();
        foreach ($results as $data) {
            $orderNUmber = $data['订单编号'];
            $express_no = $data['运单号'];
            $order = OrderModel::where('number', (int)$orderNUmber)->first();
            if (!$order) {
                continue;
            } else {
                if (empty($express_no)) {
                    continue;
                }
                $order->express_no = $express_no;
                $logistics = LogisticsModel::where('name', $data['物流公司'])->first();
                if (empty($logistics)) {
                    continue;
                }
                $order->express_id = $logistics->id;
                $order->save();
            }

        }
        DB::commit();

        return redirect('/order');
    }


    /**
     * 订单导出，匹配模板查询sql拼接
     *
     * @param array $order_mould_data
     * @return string
     * @throws \Exception
     */
    public function orderOutSelectSql(array $order_mould_data)
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
                dd($k);
                throw new \Exception('导出模板字段不存在');
            }
            $sql_data[] = $tmp_data[$k];
        }

        return implode(',', $sql_data);
    }


    public function getDaiFaSupplierData(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $supplier_id = $request->input('supplier_id');

        $start_date = date("Y-m-d H:i:s", strtotime($start_date));
        $end_date = date("Y-m-d H:i:s", strtotime($end_date));

        $supplier = SupplierModel::find($supplier_id);
        if(!$supplier){
            return view('errors.200',['message' => '供应商不存在', 'back_url' => 'order/sendOrderList']);
        }

        // 获取模板设置信息
        $tmp_data = OrderMould::mouldInfo($supplier->mould_id);
        if(!$tmp_data){
            return view('errors.200',['message' => '当前供应商未设置模板', 'back_url' => 'order/sendOrderList']);
        }

        $query = OrderModel::supplierOrderQuery($supplier_id, $start_date,$end_date);
        // 根据模板设置信息拼接sql查询语句
        $sql = $this->orderOutSelectSql($tmp_data);

        $data = $query->select(DB::raw($sql))->get();

        if(empty(count($data))){
            return view('errors.200',['message' => '当前供应商无订单', 'back_url' => 'order/sendOrderList']);
        }

        // 导出文件名
        $file_name = sprintf("%s-%s-%s",$supplier->name, $request->input('start_date'), $request->input('end_date'));

        $new_data = [];
        foreach ($data as $v){
            $new_data_1 = [];
            foreach ($v as $k1 => $v1){
                $new_data_1[$k1] = $v1;
            }
            $new_data[] = $new_data_1;
        }

        //导出Excel表单
        $this->createExcel($new_data, $file_name);
    }

}
