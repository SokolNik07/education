<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\FilterRequest;
use App\Http\Requests\Video\StoreRequest;
use App\Http\Requests\Video\UpdateRequest;
use App\Http\Resources\Video\VideoResource;
use App\Models\Video;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FilterRequest $request)
    {
        $builder = Video::query();
        $filter = $request->get('filter');
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($filter, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return VideoResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return VideoResource
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $article = Video::create($data);

        return new VideoResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param Video $id
     * @return VideoResource
     */
    public function show(Video $id)
    {
        return new VideoResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Video $id
     * @return VideoResource
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Video $id)
    {
        $this->authorize('update', $id);
        $data = $request->validated();
        $id->update($data);

        return new VideoResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Video $id
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Video $id)
    {
        $this->authorize('delete', $id);
        $id->delete();

        return Response::deny('OK');
    }
}
