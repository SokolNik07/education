<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\UpdateRequest;
use App\Http\Resources\Video\VideoResource;
use App\Models\Video;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Video $video)
    {
        $this->authorize('update', $video);
        $data = $request->validated();
        $video->update($data);
        return new VideoResource($video);
    }
}
