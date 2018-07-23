<?php

namespace App\Http\DealerTransformers;
use App\Models\UserModel;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(UserModel $user)
    {
        return [
            'id' => (int)$user->id,
            'phone' => $user->phone,
            'status' => (int)$user->status,
            'type' => (int)$user->type,
            'verify_status' => (int)$user->verify_status,
        ];
    }
}