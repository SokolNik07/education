<?php

namespace App\Http\Controllers\Character;

use App\Http\Controllers\Controller;
use App\Http\Requests\Character\FilterRequest;
use App\Http\Requests\Character\StoreRequest;
use App\Http\Requests\Character\UpdateRequest;
use App\Http\Resources\Character\CharacterResource;
use App\Models\Character;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreRequest $request)
    {
        $file = $request->file('profile_image');
        $extension = $file->getClientOriginalExtension();

        $uniqueName = md5(microtime(true)) . '.' . $extension;

        if ($request->hasFile('profile_image')) {
            $path = Storage::putFileAs('files', $file, $uniqueName);
        }
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['profile_profile_image'] = $path;
        $character = Character::create($data);

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
        if ($request->hasFile('profile_image')) {
            if ($id->profile_image !== '') {
                Storage::delete($id->profile_image);

                $file = $request->file('profile_image');
                $extension = $file->getClientOriginalExtension();

                $uniqueName = md5(microtime(true)) . '.' . $extension;
                $path = Storage::putFileAs('files', $file, $uniqueName);
            }
        }
        $data = $request->validated();
        $data['profile_profile_image'] = $path;
        $id->update($data);

        return new CharacterResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Character $id
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Character $id, Request $request)
    {
        $this->authorize('delete', $id);

        if ($id->profile_image !== '') {
            Storage::delete($id->profile_image);
        }
        $id->delete();

        return response()->json(['message' => 'Файл успешно удалён.'], 200);
    }
}
