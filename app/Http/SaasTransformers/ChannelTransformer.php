<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract
{
    public function transform($channels)
    {
        return [
            'id' => (int)$channels->id,
            'number' => $channels->number,
            'distributor_user_id' => $channels->distributor_user_id,
            'created_at' => strtotime($channels->created_at),
            'price' => $channels->price,
            'user_id' => $channels->user_id,
            'status' => (int)$channels->status,
        ];

    }
}