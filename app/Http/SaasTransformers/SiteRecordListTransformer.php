<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class SiteRecordListTransformer extends TransformerAbstract
{
    public function transform($site)
    {
        return [
            'id' => $site->id,
            'mark' => $site->mark,
            'url' => $site->url,
            'count' => $site->count,
            'site_type' => $site->site_type,
            'status' => (int)$site->status,
        ];
    }


}
