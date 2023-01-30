<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\FilterRequest;
use App\Http\Resources\Video\VideoResource;
use App\Models\Article;
use App\Models\Video;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $video = Video::query();

        if (isset($data['name'])) {
            $video->where('name', 'like', "%{$data['name']}%");
        };
        if (isset($data['id'])) {
            $video->where('id', '=', "{$data['id']}");
        };
        if (isset($data['user_id'])) {
            $video->where('user_id', '=', "{$data['user_id']}");
        };
        $video = $video->paginate($perPage, ['*'], 'page', $page);

        return VideoResource::collection($video);
    }
}
