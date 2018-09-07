<?php

namespace App\Http\DealerTransformers;

use App\Models\DistributorModel;
use League\Fractal\TransformerAbstract;

class DistributorTransformer extends TransformerAbstract
{
    public function transform(DistributorModel $distributors)
    {

        return [
            'id' => (int)$distributors->id,
            'user_id' => $distributors->user_id,
            'name' => $distributors->name ? $distributors->name : '',
            'phone' => $distributors->phone ? $distributors->phone : '',
            'province' => $distributors->province,
            'city' => $distributors->city,
            'county' => $distributors->county,
            'province_id' => $distributors->province_id,
            'city_id' => $distributors->city_id,
            'county_id' => $distributors->county_id,
            'store_name' => $distributors->store_name ? $distributors->store_name : '',
            'category_id' => $distributors->categorys ? $distributors->categorys : '',
            'category' => $distributors->category ? $distributors->category : '',
            'authorization_id' => $distributors->authorizations ? $distributors->authorizations : '',
            'authorization' => $distributors->authorization ? $distributors->authorization : '',
            'operation_situation' => $distributors->operation_situation ? $distributors->operation_situation : '',
            'front' => $distributors->front,
            'Inside' => $distributors->Inside,
            'portrait' => $distributors->portrait,
            'national_emblem' => $distributors->national_emblem,
            'front_id' => $distributors->front_id,
            'Inside_id' => $distributors->Inside_id,
            'portrait_id' => $distributors->portrait_id,
            'national_emblem_id' => $distributors->national_emblem_id,
            'bank_number' => $distributors->bank_number ? $distributors->bank_number : '',
            'bank_name' => $distributors->bank_name ? $distributors->bank_name : '',
            'business_license_number' => $distributors->business_license_number ? $distributors->business_license_number : '',
            'taxpayer' => $distributors->taxpayer ? $distributors->taxpayer : '',
            'status' => $distributors->status,
            'position' => $distributors->position,
            'full_name' => $distributors->full_name,
            'legal_person' => $distributors->legal_person,
            'legal_phone' => $distributors->legal_phone,
            'legal_number' => $distributors->legal_number?$distributors->legal_number:'',
            'e_province' =>$distributors->e_province,
            'e_city' =>$distributors->e_city,
            'e_county' =>$distributors->e_county,
            'enter_province' =>$distributors->enter_province,
            'enter_city' =>$distributors->enter_city,
            'enter_county' =>$distributors->enter_county,
            'ein' =>$distributors->ein?$distributors->ein:'',
            'enter_phone' =>$distributors->enter_phone?$distributors->enter_phone:'',
        ];
    }
}