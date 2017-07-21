<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    public function transform($image)
    {
        return [
            'id' => $image->id,
            'type' => $image->type,
            'product_number' => $image->product_number,
            'describe' => $image->describe,
            'image' => $image->file,
            'image_type' => (int)$image->image_type,
            'image_size' => $image->size,
            'image_created' => $image->created_at,
            'product' => $image->product,
            'product_iamge' => $image->product_iamge ,
        ];
    }
}
