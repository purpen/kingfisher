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
            'province_id' => $distributor->province,
            'city_id' => $distributor->city_id,
            'store_name' => $distributor->store_name,
            'category_id' => $distributor->category,
            'authorization_id' => $distributor->authorization,
            'store_address' => $distributor->store_address,
            'operation_situation' => $distributor->operation_situation,
            'front_id' => $distributor->first_front,
            'Inside_id' => $distributor->first_inside,
            'portrait_id' => $distributor->first_portrait,
            'national_emblem_id' => $distributor->first_national_emblem,
            'license_id' => $distributor->first_license,
            'bank_number' => $distributor->bank_number,
            'bank_name' => $distributor->bank_name,
            'business_license_number' => $distributor->business_license_number,
            'taxpayer' => $distributor->taxpayer,
            'status' => $distributor->status,
        ];

    }
}