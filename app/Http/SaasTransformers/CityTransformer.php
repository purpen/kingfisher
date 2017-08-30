<?php
/**
 * city
 */
namespace App\Http\SaasTransformers;

use App\Models\ChinaCityModel;
use League\Fractal\TransformerAbstract;

class CityTransformer extends TransformerAbstract
{
    public function transform(ChinaCityModel $city)
    {
        return [
            'oid' => (int)$city->oid,
            'name' => (string)$city->name,
            'pid' => (int)$city->pid,
            'sort' => (int)$city->sort,
        ];
    }
}