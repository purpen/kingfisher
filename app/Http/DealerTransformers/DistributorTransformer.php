<?php

namespace App\Http\DealerTransformers;

use App\Models\DistributorModel;
use League\Fractal\TransformerAbstract;

class DistributorTransformer extends TransformerAbstract
{
    public function transform(DistributorModel $distributors){

        return [
            'id' => (int)$distributors->id,
            'user_id' => $distributors->user_id,
            'name' => $distributors->name,
            'phone' => $distributors->phone,
            'province_id' => $distributors->province,
            'city_id' => $distributors->city_id,
            'store_name' => $distributors->store_name,
            'category_id' => $distributors->category,
            'authorization_id' => $distributors->authorization,
            'store_address' => $distributors->store_address,
            'operation_situation' => $distributors->operation_situation,
            'front' => $distributors->first_front,
            'Inside' => $distributors->first_inside,
            'portrait' => $distributors->first_portrait,
            'national_emblem' => $distributors->first_national_emblem,
            'license' => $distributors->first_license,
            'front_id' =>$distributors->front_id,
            'Inside_id'=>$distributors->Inside_id,
            'portrait_id'=>$distributors->portrait_id,
            'national_emblem_id'=>$distributors->national_emblem_id,
            'license_id'=>$distributors->license_id,
            'bank_number' => $distributors->bank_number,
            'bank_name' => $distributors->bank_name,
            'business_license_number' => $distributors->business_license_number,
            'taxpayer' => $distributors->taxpayer,
            'status' => $distributors->status,
        ];

    }
}