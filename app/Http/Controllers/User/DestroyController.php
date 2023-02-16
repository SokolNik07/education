<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;

class DestroyController extends Controller
{
    public function __invoke(User $user)
    {
        $this->authorize('delete', auth()->user());
        $user->delete();
        return ('OK');
    }
}
