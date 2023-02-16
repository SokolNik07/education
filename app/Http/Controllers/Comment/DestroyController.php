<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class DestroyController extends Controller
{
    public function __invoke(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return ('OK');
    }
}
