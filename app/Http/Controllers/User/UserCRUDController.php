<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\FilterRequest;
use App\Http\Requests\User\RegistrationRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FilterRequest $request)
    {
        $builder = User::query();
        $filter = $request->get('filter');
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($filter, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return UserResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegistrationRequest $request
     * @return UserResource
     * @throws AuthorizationException
     */
    public function store(RegistrationRequest $request)
    {
        $this->authorize('create', auth()->user());
        $data = $request->validated();

        if (User::where('name', '=', $data['name'])->exists()) {
            print_r('ИМЯ ЗАНЯТО!');
        }
        if (User::where('email', '=', $data['email'])->exists()) {
            print_r('email занят!');
        }

        $user = User::create($data);

        if ($user) {
            event(new Registered($user));
            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $id
     * @return UserResource
     * @throws AuthorizationException
     */
    public function show(User $id)
    {
        $this->authorize('view', auth()->user());
        return new UserResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $id
     * @return UserResource
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, User $id)
    {
        $this->authorize('update', auth()->user());
        $data = $request->validated();
        $id->update($data);
        return new UserResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $id
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(User $id)
    {
        $this->authorize('delete', $id);
        $id->delete();

        return Response::deny('OK');
    }
}
