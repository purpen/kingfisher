<?php
/**
 * city
 */
namespace App\Http\DealerTransformers;

use App\Models\ChinaCityModel;
use League\Fractal\TransformerAbstract;

class CityTransformer extends TransformerAbstract
{
    public function transform(ChinaCityModel $city)
    {
        return [
            'value' => (int)$city->oid,
            'label' => (string)$city->name,
            'pid' => (int)$city->pid,
            'sort' => (int)$city->sort,
        ];
    }
}