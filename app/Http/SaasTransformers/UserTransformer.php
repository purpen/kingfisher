<?php

namespace App\Http\SaasTransformers;

use App\Models\UserModel;
use League\Fractal\TransformerAbstract;

/**
 * 用户信息 （用户自己使用）
 * Class UserTransformer
 * @package App\Http\Transformer
 */
class UserTransformer extends TransformerAbstract
{
    public function transform(UserModel $user)
    {
        return [
            'id' => (int)$user->id,
            'account' => $user->account,
//            'email' => $user->email,
            'phone' => $user->phone,
//            'realname' => $user->realname,
            'cover' => $user->cover_id ? $user->cover->file : null,
        ];
    }
}