<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class HourOrderTransformer extends TransformerAbstract
{
    public function transform($order)
    {
        $data = $order->toArray();
        unset($data['change_status'], $data['form_app_val']);
        return $data;
    }
}