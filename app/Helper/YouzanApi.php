<?php
/**
 * 有赞api接口类
 * Created by PhpStorm.
 * User: cailiguang
 * Date: 2017/10/19
 * Time: 上午9:53
 */

namespace App\Helper;


use App\Models\StoreModel;
use Illuminate\Support\Facades\Log;

include(dirname(__FILE__) . '/../Libraries/YouZanSdk/lib/YZTokenClient.php');

class YouzanApi
{
    /**
     * 获取有赞token
     * @return \TopClient
     */
    public function YZToken()
    {
        $store = new StoreModel();
        $token = $store->yzToken();
        $yzToken = $token['access_token'];

        return $yzToken;

    }

    /**
     * 获取有赞卖家已卖出的订单列表
     */
    public function YzOrders()
    {
        $yzToken = $this->YZToken();
        $client = new \YZTokenClient($yzToken);

        $method = config('youzan.orders'); //要调用的api名称
        $api_version = config('youzan.api_version'); //要调用的api版本号
        //填写搜索限制
        $my_params = [
            //已发货的订单
            'status' => 'WAIT_BUYER_CONFIRM_GOODS',
            //分页1
            'page_no' => 1,
            'page_size' => '500',
            //订单开始时间
            'start_created' => date("Y-m-d H:i:s",strtotime("-" . 30 ." day")),
            //订单结束时间
            'end_created' => date('Y-m-d h:i:s'),
        ];

        $c = $client->get($method, $api_version, $my_params);
        return $c;
    }

    /**
     * 有赞更新sku库存
     */
    public function SkuQuantity($item_id , $sku_id , $quantity)
    {
        $yzToken = $this->YZToken();
        $client = new \YZTokenClient($yzToken);
        $method = config('youzan.sku_update'); //要调用的api名称
        $api_version = config('youzan.api_version'); //要调用的api版本号
        //填写搜索限制
        $my_params = [
            'item_id' => $item_id,
            'quantity' => $quantity,
            'sku_id' => $sku_id,
        ];

        $c = $client->post($method, $api_version, $my_params);
        return $c;
    }
}