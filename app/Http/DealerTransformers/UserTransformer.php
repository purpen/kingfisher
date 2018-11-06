<?php

namespace App\Http\DealerTransformers;
use App\Models\UserModel;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(UserModel $users)
    {
        return [
            'id' => (int)$users->id,
            'phone' => $users->phone,
            'name' => $users->name,
            'status' => (int)$users->status,
            'type' => (int)$users->type,
            'file' => $users->file,
            'verify_status' => (int)$users->verify_status,
            'distributor_status'=>$users->distributor_status,
            'distributor_mode'=>$users->distributor_mode,
        ];
    }
}