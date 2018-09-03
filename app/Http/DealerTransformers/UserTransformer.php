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
            'account' => $user->account,
            'realname' => $user->realname,
            'status' => (int)$user->status,
            'type' => (int)$user->type,
            'file' => $user->file,
            'verify_status' => (int)$user->verify_status,
            'distributor_status'=>$user->distributor_status,
        ];
    }
}