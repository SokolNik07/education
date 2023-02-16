<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoResource;
use App\Models\Video;

class ShowController extends Controller
{
    public function __invoke(Video $video)
    {
        return new VideoResource($video);
    }
}
