<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;

class DestroyController extends Controller
{
    public function __invoke(Article $article)
    {
        $this->authorize('delete', $article);

//        if (Article::where('id', '=', $article['id'])->exists()) {
//            $article->delete();
//            return ('OK');
//        }
//        return ('Не ОК');

        $article->delete();
        return ('OK');
    }
}
