<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{
    public function transform($supplier)
    {
        return [
            'random_id' => $supplier->random_id,
         ];
    }
}
