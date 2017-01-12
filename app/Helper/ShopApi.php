<?php
/**
 * 自营商城接口处理类
 *
 * @user llh
 */
namespace App\Helper;

use App\Models\LogisticsModel;
use App\Models\OrderModel;
use Illuminate\Support\Facades\Log;

class ShopApi
{
    //post请求函数
    public function Post($url,array $data)
    {
        $url = config('shop.url') . $url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function Get($url,array $data)
    {
        
    }
    
    /**
     * 自营商城 单页订单列表
     *
     * @param $page
     * @param int $size
     * @return mixed
     */
    public function pullOrder($page,$size = 20)
    {
        $data = ['page' => $page,'size' => $size,'sort' => 0,'status' => 2];
        $result = $this->Post(config('shop.order_list'), $data);

        $result = json_decode($result,true);
        return $result;
    }

    /**
     * 合并获取的订单列表
     *
     * @return array
     */
    public function pullOderList()
    {
        $result = $this->pullOrder(1);
        if (!$result['success']){
            return ['false','获取订单列表失败'];
        }
        $order_list = $result['data']['rows'];
        $total_page = $result['data']['total_page'];

        for ($i = 2;$i <= $total_page; $i++){
            $result = $this->pullOrder($i);
            if (!$result['success']){
                return [false,'获取订单列表失败'];
            }
            $order_list = array_merge($order_list,$result['data']['rows']);
        }

        return [true,$order_list];
    }
    
    /**
     *自营店铺发货同步
     *
     * @param $rid
     * @param $express_caty
     * @param $express_no
     * @return mixed
     */
    public function send_goods($order_id, $express_caty, $express_no)
    {
        $orderModel = OrderModel::find($order_id);

        // 如果未拆单
        if($orderModel->split_status == 0){
            $express_caty = LogisticsModel::find($express_caty)->zy_logistics_id;
            $outside_target_id = $orderModel->outside_target_id;
            $data = ['rid' => $outside_target_id, 'express_caty' => $express_caty, 'express_no' => $express_no];
        }else if($orderModel->split_status == 1){
            //如果拆单
            $orders = OrderModel::where(['outside_target_id' => $orderModel->outside_target_id,'store_id' => $orderModel->store_id])->get();
            $array = [];
            foreach ($orders as $v){
                if($v->status < 10){
                    return true;
                }
                $number = $v->number;
                $express_caty = LogisticsModel::find($v->express_id)->zy_logistics_id;
                $express_no = $v->express_no;
                $array[] = ['id' => $number, 'express_caty' => $express_caty, 'express_no' => $express_no];
            }

            $data = ['rid' => $orderModel->outside_target_id, 'array' => json_encode($array)];
        }

        $result = $this->Post(config('shop.send_goods'), $data);
        $result = json_decode($result,true);

        return $result['success'];
    }

    /**
     *  自营店铺同步sku库存接口
     * @param string $number sku编号
     * @param integer $quantity 可卖库存数量
     * @return mixed
     */
    public function changSkuCount($number,$quantity)
    {
        $data = ['number' => $number, 'quantity' => $quantity];
        $result = $this->Post(config('shop.sku_quantity'), $data);
        $result = json_decode($result,true);

        return $result['success'];
    }

    /**
     * 获取商品信息接口
     *
     * @param int $page 页码
     * @param int $size 每页数量
     * @param int $sort 排序
     * @return mixed
     */
    public function getProduct($page = 1,$size = 20,$sort = 0)
    {
        $data = ['page' => $page,'size' => $size,'sort' => $sort];
        $result = $this->Post(config('shop.product_list'), $data);

        $result = json_decode($result,true);
        return $result;
    }

    /**
     * 获取商品SKU信息
     *
     * @param int $page
     * @param int $size
     * @param int $sort
     * @return mixed
     */
    public function getProductSku($page = 1,$size = 20,$sort = 0)
    {
        $data = ['page' => $page,'size' => $size,'sort' => $sort];
        $result = $this->Post(config('shop.product_sku_list'), $data);

        $result = json_decode($result,true);
        return $result;
    }

    /**
     * 同步拆单信息
     *
     * @param $rid
     * @param $split_info
     * @return mixed
     */
    public function postSplitOrderInfo($rid,$split_info)
    {
        $data = ['rid' => $rid, 'array' => $split_info];
        $result = $this->Post(config('shop.split_order_info'), $data);
        $result = json_decode($result,true);
        return $result;
    }

    /**
     * 获取订单详细信息
     *
     * @param $rid
     * @return mixed
     */
    public function getOrderInfo($rid)
    {
        $data = ['rid' => $rid];
        $result = $this->Post(config('shop.order_info'), $data);
        $result = json_decode($result,true);
        return $result;
    }

    /**
     * 获取退款/退货/返修 单列表
     *
     * @param int $page 页码
     * @param int $size 每页数量
     * @param int $type 类型
     * @param int $stage 状态
     * @return mixed
     */
    public function getRefundList($page, $size=20, $type=0, $stage=1)
    {
        $data = ['page' => $page,'size' => $size,'type' => $type,'stage' => $stage];
        $result = $this->Post(config('shop.refund_list'), $data);
        $result = json_decode($result,true);
        return $result;
    }

    //获取退款/退货/返修 详细信息
    public function getRefundShow($number)
    {
        $data = ['number' => $number];
        $result = $this->Post(config('shop.refund_show'), $data);
        $result = json_decode($result,true);
        return $result;
    }

}