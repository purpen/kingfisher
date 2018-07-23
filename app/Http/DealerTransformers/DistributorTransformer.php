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
            'province_id' => $distributor->province_id,
            'city_id' => $distributor->city_id,
            'store_name' => $distributor->store_name,
            'category_id' => $distributor->category_id,
            'authorization_id' => $distributor->authorization_id,
            'store_address' => $distributor->store_address,
            'operation_situation' => $distributor->operation_situation,
            'front_id' => $distributor->front_id ? $distributor->front_id : '',
            'Inside_id' => $distributor->Inside_id ? $distributor->Inside_id : '',
            'portrait_id' => $distributor->portrait_id ? $distributor->portrait_id: '',
            'national_emblem_id' => $distributor->national_emblem_id ? $distributor->national_emblem_id : '',
            'license_id' => $distributor->license_id ? $distributor->license_id : '',
            'bank_number' => $distributor->bank_number,
            'bank_name' => $distributor->bank_name,
            'business_license_number' => $distributor->business_license_number,
            'taxpayer' => $distributor->taxpayer,
        ];

    }
}