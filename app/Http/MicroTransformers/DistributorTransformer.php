<?php

namespace App\Http\MicroTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class DistributorTransformer extends TransformerAbstract
{

    public function transform($distributor)
    {

        return [
            'account' => $distributor->account,
            'phone' => $distributor->phone,
        ];
    }


}