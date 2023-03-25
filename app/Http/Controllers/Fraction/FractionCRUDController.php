<?php

namespace App\Http\Controllers\Fraction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fraction\FilterRequest;
use App\Http\Requests\Fraction\StoreRequest;
use App\Http\Requests\Fraction\UpdateRequest;
use App\Http\Resources\Fraction\FractionResource;
use App\Models\Fraction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FractionCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FilterRequest $request)
    {
        $builder = Fraction::query();
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($request, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return FractionResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return FractionResource
     */
    public function store(StoreRequest $request, Fraction $id)
    {
        $fraction = $this->crudService->create($request, $id);

        return new FractionResource($fraction);
    }

    /**
     * Display the specified resource.
     *
     * @param Fraction $id
     * @return FractionResource
     */
    public function show(Fraction $id)
    {
        return new FractionResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Fraction $id
     * @return FractionResource
     */
    public function update(UpdateRequest $request, Fraction $id)
    {
        $this->crudService->update($request, $id);

        return new FractionResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Fraction $id
     * @return JsonResponse
     */
    public function destroy(Fraction $id)
    {
        $this->crudService->destroy($id);

        return response()->json(['message' => 'Файл успешно удалён.'], 200);
    }
}
