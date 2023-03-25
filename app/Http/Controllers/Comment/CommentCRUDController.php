<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\FilterRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Auth\Access\Response;

class CommentCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FilterRequest $request)
    {
        $builder = Comment::query();
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($request, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return CommentResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return CommentResource
     */
    public function store(StoreRequest $request, Comment $id)
    {
        $comment = $this->crudService->create($request, $id);

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $id
     * @return CommentResource
     */
    public function show(Comment $id)
    {
        return new CommentResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Comment $id
     * @return CommentResource
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Comment $id)
    {
        $this->authorize('update', $id);
        $this->crudService->update($request, $id);

        return new CommentResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $id
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Comment $id)
    {
        $this->authorize('delete', $id);
        $this->crudService->destroy($id);

        return Response::deny('OK');
    }
}
