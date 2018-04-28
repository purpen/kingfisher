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
            'phone' => $user->phone,
            'status' => $user->status,
            'type' => $user->type,
            'verify_status' => $user->verify_status,
            'cover' => $user->cover ? $user->cover->file : null,
            'mould_id' => $user->mould_id ? $user->mould_id : 0,
            'name' => $user->distribution ? $user->distribution->name : '',
            'company' => $user->distribution ? $user->distribution->company : '',
            'introduction' => $user->distribution ? $user->distribution->introduction : '',
            'main' => $user->distribution ? $user->distribution->main : '',
            'create_time' => $user->distribution ? $user->distribution->create_time : '',
            'contact_name' => $user->distribution ? $user->distribution->contact_name : '',
            'contact_phone' => $user->distribution ? $user->distribution->contact_phone : '',
            'contact_qq' => $user->distribution ? $user->distribution->contact_qq : '',
            'company_type' => $user->distribution ? $user->distribution->company_type : '',
            'company_type_value' => $user->distribution ? $user->distribution->company_type_value : '',
            'registration_number' => $user->distribution ? $user->distribution->registration_number : '',
            'legal_person' => $user->distribution ? $user->distribution->legal_person : '',
            'document_type' => $user->distribution ? $user->distribution->document_type : '',
            'document_type_value' => $user->distribution ? $user->distribution->document_type_value : '',
            'document_number' => $user->distribution ? $user->distribution->document_number : '',
            'email' => $user->distribution ? $user->distribution->email : '',
            'position' => $user->distribution ? $user->distribution->position : '',
            "license_image" => $user->distribution ? $user->distribution->license_image : null,                   // 企业证件附件
            "document_image" => $user->distribution ? $user->distribution->document_image : null,
        ];
    }


}