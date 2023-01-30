<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\FilterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $user = User::query();

        if (isset($data['name'])) {
            $user->where('name', 'like', "%{$data['name']}%");
        };

        if (isset($data['email'])) {
            $user->where('email', 'like', "%{$data['email']}%");
        };
        if (isset($data['id'])) {
            $user->where('id', '=', "{$data['id']}");
        };
        $user = $user->paginate($perPage, ['*'], 'page', $page);

        return UserResource::collection($user);
    }
}
