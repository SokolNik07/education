<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\FilterRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $builder = Article::query();
        $filter = $request->get('filter');
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($filter, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return ArticleResource::collection($result);


    }
}
