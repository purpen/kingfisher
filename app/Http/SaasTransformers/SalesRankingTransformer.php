<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class SalesRankingTransformer extends TransformerAbstract
{
    public $sum;  // 总金额
    public function __construct($sum)
    {
        $this->sum = $sum;
    }

    public function transform($order)
    {
        $data = $order->toArray();
        $data['proportion'] = sprintf('%0.2f', $data['sum_money'] / $this->sum*100);
        unset($data['refund_status_val']);
        return $data;
    }
}