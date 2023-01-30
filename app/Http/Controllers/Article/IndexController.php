<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\FilterRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $article = Article::query();

        if (isset($data['name'])) {
            $article->where('name', 'like', "%{$data['name']}%");
        };
        if (isset($data['article'])) {
            $article->where('article', 'like', "%{$data['article']}%");
        };
        if (isset($data['id'])) {
            $article->where('id', '=', "{$data['id']}");
        };
        if (isset($data['user_id'])) {
            $article->where('user_id', '=', "{$data['user_id']}");
        };

        $article = $article->paginate($perPage, ['*'], 'page', $page);

        return ArticleResource::collection($article);
    }
}
