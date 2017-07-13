<?php

namespace App\Http\Transformer;

use App\Models\User;
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
            'email' => $user->email,
            'phone' => $user->phone,
            'status' => $user->status,
            'realname' => $user->realname,
            'position' => $user->position,
            'department' => $user->department,
        ];
    }
}