<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;

class ShowController extends Controller
{
    public function __invoke(Article $article)
    {
        return new ArticleResource($article);
    }
}
