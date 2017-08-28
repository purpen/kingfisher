<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class MembershipTransformer extends TransformerAbstract
{
    public function transform($membership)
    {
        return [
            'random_id' => $membership->random_id,
         ];
    }
}
