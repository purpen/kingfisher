<?php

namespace App\Http\SaasTransformers;

use App\Models\ArticleModel;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(ArticleModel $article)
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
            'author' => $article->author,
            'article_time' => $article->article_time,
            'article_type' => $article->article_type,
            'product_number' => $article->product_number,
            'content' => $article->content,
            'article_describe' => $article->article_describe,
            'cover_url' => $article->imageFile,
            'site_from' => $article->site_from,
            'product' => $article->product ,
        ];
    }
}
