<?php

namespace App\Http\SaasTransformers;

use App\Models\CooperationRelation;
use App\Models\ProductUserRelation;
use League\Fractal\TransformerAbstract;

/**
 * 推荐列表
 *
 * Class ProductListsTransformer
 * @package App\Http\SaasTransformers
 */
class CooperateProductListsTransformer extends TransformerAbstract
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function transform(CooperationRelation $Cooperation)
    {
        $productUserRelation = new ProductUserRelation();

        return $productUserRelation->productListInfo($this->user_id, $Cooperation->product_id);
    }


}