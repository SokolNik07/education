<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\FilterRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FilterRequest $request)
    {
        $builder = Article::query();
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($request, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return ArticleResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return ArticleResource
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $article = Article::create($data);

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $id
     * @return ArticleResource
     */
    public function show(Article $id)
    {
        return new ArticleResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Article $id
     * @return ArticleResource
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Article $id)
    {
        $this->authorize('update', $id);
        $data = $request->validated();
        $id->update($data);

        return new ArticleResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $id
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Article $id)
    {
        $this->authorize('delete', $id);
        $id->delete();

        return Response::deny('OK');
    }
}
