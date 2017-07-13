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
        ];
    }
}