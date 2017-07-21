<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform($article)
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
            'P800article_image' => $article->article_image.'-p800',
            'p280article_image' => $article->article_image.'-p280.210',
            'site_from' => $article->site_from,
            'products' => $article->product ,
        ];
    }
}
