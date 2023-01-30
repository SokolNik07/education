<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\UpdateRequest;
use App\Models\Article;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Article $article)
    {
    $data = $request->validated();

    $article->update($data);
    }
}
