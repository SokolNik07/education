<?php

namespace App\Http\Controllers\Fraction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fraction\FilterRequest;
use App\Http\Requests\Fraction\StoreRequest;
use App\Http\Requests\Fraction\UpdateRequest;
use App\Http\Resources\Fraction\FractionResource;
use App\Models\Fraction;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreRequest $request)
    {
        $file = $request->file('banner');
        $extension = $file->getClientOriginalExtension();

        $uniqueName = md5(microtime(true)) . '.' . $extension;

        if ($request->hasFile('banner')) {
            $path = Storage::putFileAs('files', $file, $uniqueName);
        }
        $data = $request->validated();
        $data['founder'] = $request->user()->id;
        $data['banner'] = $path;
        $character = Fraction::create($data);

        return new FractionResource($character);
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
        if ($request->hasFile('banner')) {
            if ($id->banner !== '') {
                Storage::delete($id->banner);

                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();

                $uniqueName = md5(microtime(true)) . '.' . $extension;
                $path = Storage::putFileAs('files', $file, $uniqueName);
            }
        }
        $data = $request->validated();
        $data['banner'] = $path;
        $id->update($data);

        return new FractionResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Fraction $id
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Fraction $id, Request $request)
    {
        $this->authorize('delete', $id);

        if ($id->banner !== '') {
            Storage::delete($id->banner);
        }
        $id->delete();

        return response()->json(['message' => 'Файл успешно удалён.'], 200);
    }
}
