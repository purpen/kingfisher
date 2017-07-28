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
            'asset' => $videos->file,
            'video' => $videos->file->srcfile,
            'video_image' => $videos->file->video,
            'video_size' => $videos->size,
            'video_created' => $videos->created_at,
            'product' => $videos->product,
        ];
    }
}
