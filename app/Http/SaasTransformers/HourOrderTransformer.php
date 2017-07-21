<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class HourOrderTransformer extends TransformerAbstract
{
    public function transform($order)
    {
        $data = $order;
        unset($data['change_status'], $data['form_app_val']);



        return $data;
    }

    protected function data($data)
    {
        $new_data = [];

        for ($i = 0; $i < 24; $i++){
            foreach ($data as $v){
                if((int)$i == (int)$v['time']){
                    $new_data[] = $v;
                    break;
                }
            }
            $new_data[] = [
                "order_count" => '',
                "sum_money" => '',
                "time" => (string)$i,
            ];
        }

        return $new_data;
    }

}