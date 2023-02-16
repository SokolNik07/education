<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\StoreRequest;
use App\Http\Resources\Video\VideoResource;
use App\Models\Video;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data['user_id'] = $request->user()->id;
        $data = $request->validated();
        $video = Video::create($data);
        return new VideoResource($video);
    }
}
