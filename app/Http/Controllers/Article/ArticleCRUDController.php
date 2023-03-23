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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        Log::channel((new Article)->getTable())->info("Пользователь: id({$request->user()->id}) name: {$request->user()->name} = просмотрел список сущностей");

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
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $uniqueName = md5(microtime(true)) . '.' . $extension;

        if ($request->hasFile('image')) {
            $path = Storage::putFileAs('files', $file, $uniqueName);
        }
        $data = [
            'name' => $request['name'],
            'article' => $request['article'],
            'user_id' => $request->user()->id,
            'image' => $path,
        ];
        $article = Article::create($data);

        Log::channel((new Article)->getTable())->info("Пользователь: id({$request->user()->id}) name: {$request->user()->name} = создал новую сущность = {$article}");

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $id
     * @return ArticleResource
     */
    public function show(Article $id, Request $request)
    {
        Log::channel((new Article)->getTable())->info("Пользователь: id({$request->user()->id}) name: {$request->user()->name} = просмотрел сущность: {$id}");
        return new ArticleResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Article $id
     * @return ArticleResource
     */
    public function update(UpdateRequest $request, Article $id)
    {
        if ($request->hasFile('image')) {
            if ($id->image !== '') {
                Storage::delete($id->image);

                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                $uniqueName = md5(microtime(true)) . '.' . $extension;
                $path = Storage::putFileAs('files', $file, $uniqueName);
            }
        }
        $data = [
            'name' => $request['name'] ?? $id->name,
            'article' => $request['article'] ?? $id->article,
            'user_id' => $request->user()->id,
            'image' => $path ?? $id->image,
        ];
        $id->update($data);

        Log::channel((new Article)->getTable())->info("Пользователь: id({$request->user()->id}) name: {$request->user()->name} = обновил сущность {$id}");

        return new ArticleResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Article $id, Request $request)
    {
        $this->authorize('delete', $id);

        if ($id->image !== '') {
            Storage::delete($id->image);
        }
        $id->delete();

        Log::channel((new Article)->getTable())->info("Пользователь: id({$request->user()->id}) name: {$request->user()->name} = удалил сущность {$id}");

        return response()->json(['message' => 'Файл успешно удалён.'], 200);
    }
}
