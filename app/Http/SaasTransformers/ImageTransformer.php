<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    public function transform($describes)
    {
        return [
            'id' => $describes->id,
            'type' => $describes->type,
            'product_number' => $describes->product_number,
            'describe' => $describes->describe,
            'image' => $describes->first_img,
        ];
    }
}
