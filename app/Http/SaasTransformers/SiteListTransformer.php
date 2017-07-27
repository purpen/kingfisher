<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class SiteListTransformer extends TransformerAbstract
{
    public function transform($site)
    {
        return [
            'id' => $site->id,
            'user_id' => $site->user_id,
            'mark' => $site->mark,
            'url' => $site->url,
            'name' => $site->name,
            'site_type' => $site->site_type,
            'status' => (int)$site->status,
        ];
    }


}
