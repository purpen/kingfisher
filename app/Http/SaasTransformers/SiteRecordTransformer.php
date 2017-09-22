<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class SiteRecordTransformer extends TransformerAbstract
{
    public function transform($site)
    {
        return [
            'id' => $site->id,
            'mark' => $site->mark,
            'url' => $site->url,
            'category' => $site->category,
            'site_type' => $site->site_type,
            'count' => $site->count,
            'status' => (int)$site->status,
        ];
    }

}
