<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class VideoTransformer extends TransformerAbstract
{
    public function transform($videos)
    {
        return [
            'id' => $videos->id,
            'type' => $videos->type,
            'product_number' => $videos->product_number,
            'describe' => $videos->describe,
            'video' => $videos->file->srcfile,
            'image_size' => $videos->size,
            'image_created' => $videos->created_at,

        ];
    }
}
