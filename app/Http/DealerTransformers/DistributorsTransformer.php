<?php

namespace App\Http\DealerTransformers;

use App\Models\DistributorsModel;
use League\Fractal\TransformerAbstract;

class DistributorsTransformer extends TransformerAbstract
{
    public function transform(DistributorsModel $distributors){

        return [
            'id' => (int)$distributors->id,
            'user_id' => $distributors->user_id,
            'name' => $distributors->name,
            'province_id' => $distributors->province_id,
            'city_id' => $distributors->city_id,
            'store_name' => $distributors->store_name,
            'category_id' => $distributors->category_id,
            'authorization_id' => $distributors->authorization_id,
            'store_address' => $distributors->store_address,
            'operation_situation' => $distributors->operation_situation,
            'front_id' => $distributors->front_id ? $distributors->front_id : '',
            'Inside_id' => $distributors->Inside_id ? $distributors->Inside_id : '',
            'portrait_id' => $distributors->portrait_id ? $distributors->portrait_id: '',
            'national_emblem_id' => $distributors->national_emblem_id ? $distributors->national_emblem_id : '',
            'license_id' => $distributors->license_id ? $distributors->license_id : '',
            'bank_number' => $distributors->bank_number,
            'bank_name' => $distributors->bank_name,
            'business_license_number' => $distributors->business_license_number,
            'taxpayer' => $distributors->taxpayer,
        ];

    }
}