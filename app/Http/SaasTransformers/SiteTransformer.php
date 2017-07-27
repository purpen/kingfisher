<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class SiteTransformer extends TransformerAbstract
{
    public function transform($site)
    {
        return [
            'id' => $site->id,
            'user_id' => $site->user_id,
            'mark' => $site->mark,
            'url' => $site->url,
            'grap_url' => $site->grap_url,
            'name' => $site->name,
            'site_type' => $site->site_type,
            'items' => $site->items,
            'status' => (int)$site->status,
        ];
    }

}
