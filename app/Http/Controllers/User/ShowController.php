<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class ShowController extends Controller
{
    public function __invoke(User $user)
    {
        $this->authorize('view', auth()->user());
        return new UserResource($user);
    }
}
