<?php

namespace App\Http\DealerTransformers;

use App\Models\DistributorModel;
use League\Fractal\TransformerAbstract;

class DistributorTransformer extends TransformerAbstract
{
    public function transform(DistributorModel $distributor){

        return [
            'id' => (int)$distributor->id,
            'user_id' => $distributor->user_id,
            'name' => $distributor->name,
            'phone' => $distributor->phone,
            'province_id' => $distributor->province_id,
            'city_id' => $distributor->city_id,
            'store_name' => $distributor->store_name,
            'category_id' => $distributor->category_id,
            'authorization_id' => $distributor->authorization_id,
            'store_address' => $distributor->store_address,
            'operation_situation' => $distributor->operation_situation,
            'front_id' => $distributor->front ? $distributor->front : null(),
            'Inside_id' => $distributor->Inside ? $distributor->Inside : null(),
            'portrait_id' => $distributor->portrait ? $distributor->portrait : null(),
            'national_emblem_id' => $distributor->national_emblem ? $distributor->national_emblem : null(),
            'license_id' => $distributor->license ? $distributor->license : null(),
            'bank_number' => $distributor->bank_number,
            'bank_name' => $distributor->bank_name,
            'business_license_number' => $distributor->business_license_number,
            'taxpayer' => $distributor->taxpayer,
        ];

    }
}