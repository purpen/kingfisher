<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class DescribeTransformer extends TransformerAbstract
{
    public function transform($describes)
    {
        return [
            'id' => $describes->id,
            'type' => $describes->type,
            'product_number' => $describes->product_number,
            'describe' => $describes->describe,
            'product' => $describes->product,
            'product_iamge' => $describes->product_iamge ,

        ];
    }
}
