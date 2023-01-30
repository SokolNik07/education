<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\FilterRequest;
use App\Http\Resources\Comment\CommentResource;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $comment = Comment::query();

        if (isset($data['comment'])) {
            $comment->where('comment', 'like', "%{$data['comment']}%");
        };
        if (isset($data['article_id'])) {
            $comment->where('article_id', '=', "{$data['article_id']}");
        };
        if (isset($data['user_id'])) {
            $comment->where('user_id', '=', "{$data['user_id']}");
        };
        $comment = $comment->paginate($perPage, ['*'], 'page', $page);

        return CommentResource::collection($comment);
    }
}
