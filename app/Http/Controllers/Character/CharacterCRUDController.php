<?php

namespace App\Http\Controllers\Character;

use App\Http\Controllers\Controller;
use App\Http\Requests\Character\FilterRequest;
use App\Http\Requests\Character\StoreRequest;
use App\Http\Requests\Character\UpdateRequest;
use App\Http\Resources\Character\CharacterResource;
use App\Models\Character;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CharacterCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FilterRequest $request)
    {
        $builder = Character::query();
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($request, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return CharacterResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return CharacterResource
     */
    public function store(StoreRequest $request, Character $id)
    {
        $character = $this->crudService->create($request, $id);

        return new CharacterResource($character);
    }

    /**
     * Display the specified resource.
     *
     * @param Character $id
     * @return CharacterResource
     */
    public function show(Character $id)
    {
        return new CharacterResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Character $id
     * @return CharacterResource
     */
    public function update(UpdateRequest $request, Character $id)
    {
        $this->crudService->update($request, $id);

        return new CharacterResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Character $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Character $id)
    {
        $this->crudService->destroy($id);

        return response()->json(['message' => 'Файл успешно удалён.'], 200);
    }
}
