<?php
namespace App\Http\DealerTransformers;

use App\Models\CategoriesModel;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(CategoriesModel $categories)
    {
        return [
            'id' => (int)$categories->id,
            'title' => (string)$categories->title,
        ];
    }

}