<?php

namespace App\Http\MicroTransformers;

use App\Models\DeliveryAddressModel;
use League\Fractal\TransformerAbstract;

class DeliveryAddressTransformer extends TransformerAbstract
{

    public function transform(DeliveryAddressModel $address)
    {
        $province = $city = $county = $town = '';
        if ($address->province) $province = $address->province->name;
        if ($address->city) $city = $address->city->name;
        if ($address->county) $county = $address->county->name;
        if ($address->town) $town = $address->town->name;
        return [
            'id' => $address->id,
            'user_id' => $address->user_id,
            'name' => $address->name,
            'phone' => $address->phone,
            'email' => $address->email,
            'province_id' => $address->province_id,
            'province' => $province,
            'city_id' => $address->city_id,
            'city' => $city,
            'county_id' => $address->county_id,
            'county' => $county,
            'town_id' => $address->town_id,
            'town' => $town,
            'address' => $address->address,
            'is_default' => $address->is_default,
            'type' => $address->type,
            'status' => $address->status,
        ];
    }


}
