<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\FilterRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;

class Index extends Controller
{
 public $request;
    public function __invoke(FilterRequest $request, Article $model)
    {
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;

        $builder = $model->query();

        if (isset($request['name'])) {
            $builder->where('name', 'ilike', "%{$request['name']}%");
        }
        if (isset($request['article'])) {
            $builder->where('article', 'ilike', "%{$request['article']}%");
        }
        if (isset($request['id'])) {
            $builder->where('id', '=', $request['id']);
        }
        if (isset($request['user_id'])) {
            $builder->where('user_id', '=', $request['user_id']);
        }

        $builder = $builder->paginate($perPage, ['*'], 'page', $page);

        return ArticleResource::collection($builder);
    }
}
