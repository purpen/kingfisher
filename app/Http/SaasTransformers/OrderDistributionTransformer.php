<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class OrderDistributionTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return $data;
    }
}